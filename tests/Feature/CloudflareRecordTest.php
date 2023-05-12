<?php

use App\Http\Livewire\CreateCloudflareRecordForm;
use App\Http\Livewire\EditCloudflareRecordForm;
use App\Models\CloudflareRecord;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Laravel\Jetstream\Features;
use Livewire\Livewire;

beforeEach(function () {
    if (Features::hasTeamFeatures()) {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    } else {
        $this->actingAs($user = User::factory()->create());
    }

    $this->user = $user->fresh();

    $this->cloudflareInput = Arr::except(CloudflareRecord::factory()->make(['hostname' => 'test-cf'])->toArray(), [
        'data',
        'fqdn',
        'cached_ip',
    ]);

});

it('has create cloudflare record page', function () {
    $response = $this->get(route('cloudflare-records.create'));

    $response->assertStatus(200);
});

it('can create cloudflare record', function () {
    Artisan::shouldReceive('call')
        ->once()
        ->with('update-dns');

    Livewire::test(CreateCloudflareRecordForm::class)
        ->set(['state' => $this->cloudflareInput])
        ->call('create');

    expect($this->user->fresh()->cloudflareRecords)->toHaveCount(1);
    expect($this->user->fresh()->cloudflareRecords()->latest('id')->first()->hostname)->toEqual('test-cf');
});

it('has update cloudflare record page', function () {
    $cloudflareRecord = CloudflareRecord::factory()->create([
        'user_id' => $this->user->id,
        'team_id' => $this->user->currentTeam->id,
    ]);

    $response = $this->get(route('cloudflare-records.edit', $cloudflareRecord));

    $response->assertStatus(200);
});

it('can update cloudflare record', function () {
    Artisan::shouldReceive('call')
        ->once()
        ->with('update-dns');

    $cloudflareRecord = CloudflareRecord::factory()->create([
        'user_id' => $this->user->id,
        'team_id' => $this->user->currentTeam->id,
    ]);

    Livewire::test(EditCloudflareRecordForm::class, ['cloudflareRecord' => $cloudflareRecord])
        ->set(['state' => array_merge($cloudflareRecord->toArray(), $this->cloudflareInput)])
        ->call('storeRecord');

    expect($this->user->fresh()->cloudflareRecords)->toHaveCount(1);
    expect($this->user->fresh()->cloudflareRecords()->latest('id')->first()->hostname)->toEqual('test-cf');
});

it('can delete cloudflare record', function () {
    $response = $this->delete(route('cloudflare-records.destroy', CloudflareRecord::factory()->create([
        'user_id' => $this->user->id,
        'team_id' => $this->user->currentTeam->id,
    ])));

    $response->assertRedirect(route('dashboard'));
    expect($this->user->fresh()->cloudflareRecords)->toHaveCount(0);
});
