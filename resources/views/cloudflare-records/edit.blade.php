<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Edit Cloudflare Record') }}
        </h2>
    </x-slot>

    <div>
      <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
          <livewire:edit-cloudflare-record-form :cloudflareRecord="$cloudflareRecord" />
      </div>
    </div>
</x-app-layout>
