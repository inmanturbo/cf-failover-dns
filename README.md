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

`FEATURE_SEND_EMAILS` true to if you want your application to send emails notifying you of dns updates

## Config

```php
<?php
// config/features.php

return [
    'send-emails' => env('FEATURE_SEND_EMAILS', false),
];
```

## To update dns every minute

create the following cron job on your server:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Links

https://laravel.com/docs/10.x/scheduling