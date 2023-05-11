<div>
    <x-form-section submit="storeRecord">
        <x-slot name="title">
            {{ __('Edit Record') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Edit a record') }}
        </x-slot>

        <x-slot name="form">
            <!-- hostame -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Hostname') }}" />
                <x-input id="name" type="text" class="block w-full mt-1" wire:model.defer="state.hostname" autofocus />
                <x-input-error for="hostname" class="mt-2" />
            </div>

            <!-- domain -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="domain" value="{{ __('Domain') }}" />
                <x-input id="domain" type="text" class="block w-full mt-1" wire:model.defer="state.domain" autofocus />
                <x-input-error for="domain" class="mt-2" />
            </div>

            <!-- interface_ip -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="interface_ip" value="{{ __('Interface IP') }}" />
                <x-input id="interface_ip" type="text" class="block w-full mt-1" wire:model.defer="state.interface_ip" autofocus />
                <x-input-error for="interface_ip" class="mt-2" />
            </div>

            <!-- virtual_ip -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="virtual_ip" value="{{ __('Virtual IP') }}" />
                <x-input id="virtual_ip" type="text" class="block w-full mt-1" wire:model.defer="state.virtual_ip" autofocus />
                <x-input-error for="virtual_ip" class="mt-2" />
            </div>

            <!-- proxy -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="proxy" value="{{ __('Proxy') }}" />
                <x-checkbox id="proxy" wire:model.defer="state.proxy" wire:click="proxyChanged" autofocus />
                {{ $proxyChanged ? 'true' : 'false'}}
                <x-input-error for="proxy" class="mt-2" />
            </div>

            <!-- token -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="token" value="{{ __('Token') }}" />
                <x-input id="token" type="text" class="block w-full mt-1" wire:model.defer="state.token" autofocus />
                <x-input-error for="token" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button>
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-form-section>
</div>
