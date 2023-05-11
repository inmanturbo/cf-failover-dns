<x-mail::message>

# Cloudflare Record Updated

The following record has been updated on Cloudflare:

**Name:** {{ $record->fqdn }}

**Virtual IP:** {{ $record->virtual_ip }}

**Interface IP:** {{ $record->interface_ip }}

**Updated At:** {{ $record->updated_at->toDayDateTimeString() }}

**Cached IP:** {{ $record->cached_ip }}

**Proxied:** {{ $record->proxied ? 'Yes' : 'No' }}

{{ config('app.name') }}
</x-mail::message>
