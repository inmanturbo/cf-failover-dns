# Cloudflare failover DNS

## Installation

Install with composer

```bash
composer install
```

copy and edit .env

```bash
cp .env.example .env
```

## Environment

set `FEATURE_SEND_EMAILS` to true to if you want your application to send emails notifying you of dns updates

## Config

```php
<?php
// config/features.php

return [
    'send-emails' => env('FEATURE_SEND_EMAILS', false),
];
```

```php
<?php
// config/cloudflare-dns.php
return [
    // Here you can define the schedule for checking if dns records should be updated. The default is every 8 minutes ('*/8 * * * *').
    // see https://laravel.com/docs/8.x/scheduling#schedule-frequency-options for more information
    'schedule' => '*/8 * * * *',
];
```

## Scheduling DNS Updates

Create the following cron job on your server to run the artisan scheduler:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

To check and (if necessary) update dns records for example, every minute, set `config('cloudflare-dns.schedule')` to `* * * * *`.

```php
<?php
// config/cloudflare-dns.php
return [

    'schedule' => '* * * * *', // run every minute
];
```

## Links

https://laravel.com/docs/10.x/scheduling