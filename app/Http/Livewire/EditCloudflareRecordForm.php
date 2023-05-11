<?php

namespace App\Http\Livewire;

use App\Models\CloudflareRecord;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class EditCloudflareRecordForm extends Component
{

    public $state = [];

    public $proxyChanged = false;

    public function mount(CloudflareRecord $cloudflareRecord)
    {
        $this->state = $cloudflareRecord->toArray();
        unset($this->state['created_at']);
        unset($this->state['updated_at']);
        unset($this->state['fqdn']);
        unset($this->state['cached_ip']);
    }

    public function proxyChanged()
    {
        $this->proxyChanged = true;
    }

    public function update()
    {
        $this->resetErrorBag();

        Validator::make($this->state, [
            'hostname' => ['required', 'string', 'max:255'],
            'domain' => ['required','string', 'max:255'],
            'interface_ip' => ['required', 'ipv4', 'max:255'],
            'virtual_ip' => ['nullable', 'ipv4', 'max:255'],
            'proxy' => ['nullable', 'boolean'],
            'token' => ['required', 'string', 'max:255'],
            'data' => ['nullable', 'array'],
        ])->validateWithBag('editCloudflareRecordForm');

        $this->state['virtual_ip'] = $this->state['virtual_ip'] ?? $this->state['interface_ip'];
        $this->state['proxy'] = $this->state['proxy'] ?? false;
        $this->state['hostname'] = $this->state['hostname'] ?? '@';
        // $this->state['user_id'] = auth()->id();
        $this->state['team_id'] = auth()->user()->currentTeam->id;
        if($this->proxyChanged){
            $this->state['cached_ip'] = null;
        }

        $cloudflareRecord = CloudflareRecord::firstOrFail($this->state['id']);

        // dd($this->state);

        $cloudflareRecord->update($this->state);

        Artisan::call('update-dns');

        $this->emit('saved');
    }

    public function render()
    {
        return view('livewire.edit-cloudflare-record-form');
    }
}
