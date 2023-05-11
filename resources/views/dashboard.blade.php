<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                <div class="flex flex-col">
                  <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                      <div class="p-2 overflow-hidden">
                        <h2 class="py-4 text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                            {{ __('Managed Cloudflare Records') }}
                        </h2>
                        <table class="min-w-full text-sm font-light text-left">
                            <thead
                                class="font-medium bg-white border-b dark:border-neutral-500 dark:bg-neutral-600">
                                <tr>
                                    <th scope="col">Hostname</th>
                                    <th scope="col">Interface IP</th>
                                    <th scope="col">Cached IP</th>
                                    <th scope="col">Virtual IP</th>
                                    <th scope="col">Proxy</th>
                                    {{-- <th scope="col">Token</th> --}}
                                    <th scope="col">Last Update</th>
                                    <th scope="col">Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cloudflareRecords as $record)
                                <tr class="bg-white border-b dark:border-neutral-500 dark:bg-neutral-600">
                                    <td class="whitespace-nowrap">{{ $record->hostname }}.{{ $record->domain }}</td>
                                    <td class="whitespace-nowrap">{{ $record->interface_ip }}</td>
                                    <td class="whitespace-nowrap">{{ $record->cached_ip }}</td>
                                    <td class="whitespace-nowrap">{{ $record->virtual_ip }}</td>
                                    <td class="whitespace-nowrap">{{ $record->proxy ? 'Yes' : 'No' }}</td>
                                    {{-- <td class="whitespace-nowrap">{{ $record->token }}</td> --}}
                                    <td class="whitespace-nowrap">{{ $record->updated_at }}</td>
                                    <td class="whitespace-nowrap">
                                        <a href="{{ route('cloudflare-records.edit', $record->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                        <form action="{{ route('cloudflare-records.destroy', $record->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                </tr>
                                @endforeach
                          </tbody>
                        </table>

                        <div class="mt-4">
                            <a href="{{ route('cloudflare-records.create') }}">
                            <x-button class="text-white bg-blue-600 hover:bg-blue-700">
                                {{ __('New Managed Record') }}
                            </x-button>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
