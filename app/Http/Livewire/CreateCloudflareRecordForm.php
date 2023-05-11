<?php

namespace App\Http\Livewire;

use App\Models\CloudflareRecord;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CreateCloudflareRecordForm extends Component
{

    public $state = [
        'hostname' => '@',
        'domain' => null,
        'interface_ip' => null,
        'cached_ip' => null,
        'virtual_ip' => '',
        'proxy' => false,
        'data' => [],
    ];

    public function create()
    {

        $this->resetErrorBag();

        Validator::make($this->state, [
            'hostname' => ['required', 'string', 'max:255'],
            'domain' => ['required', 'string', 'max:255'],
            'interface_ip' => ['required', 'ipv4', 'max:255'],
            'virtual_ip' => ['nullable', 'ipv4', 'max:255'],
            'proxy' => ['nullable', 'boolean'],
            'token' => ['required', 'string', 'max:255'],
            'data' => ['nullable', 'array'],
        ])->validateWithBag('createCloudflareRecordForm');

        $this->state['virtual_ip'] = $this->state['virtual_ip'] ?? $this->state['interface_ip'];
        $this->state['proxy'] = $this->state['proxy'] ?? false;
        $this->state['hostname'] = $this->state['hostname'] ?? '@';
        $this->state['user_id'] = auth()->id();
        $this->state['team_id'] = auth()->user()->currentTeam->id;

        $cloudflareRecord = CloudflareRecord::create($this->state);

        Artisan::call('update-dns');

        $this->emit('saved');
    }

    public function render()
    {
        return view('livewire.create-cloudflare-record-form');
    }
}
