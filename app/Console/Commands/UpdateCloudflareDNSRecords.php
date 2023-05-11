<?php

namespace App\Console\Commands;

use App\Mail\CloudflareRecordUpdated;
use App\Models\CloudflareRecord;
use Cloudflare\API\Auth\APIToken;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class UpdateCloudflareDNSRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-dns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating DNS records...');

        $this->updateDnsRecords();

        $this->info('DNS records updated!');
    }

    /**
     * Update DNS records.
     */
    private function updateDnsRecords(): void
    {
        $dnsRecords = $this->getDnsRecords();

        foreach ($dnsRecords as $dnsRecord) {
            $this->updateDnsRecord($dnsRecord);
        }
    }

    /**
     * Get DNS records.
     */
    private function getDnsRecords(): Collection
    {
        return CloudflareRecord::all();
    }

    /**
     * Update DNS record.
     */
    private function updateDnsRecord(CloudflareRecord $dnsRecord): void
    {
        $this->info('Updating DNS record for: '.$dnsRecord->fqdn);

        $currentInterfaceIp = $this->getCurrentInterfaceIp();

        $cachedIp = filter_var($dnsRecord->cached_ip, FILTER_VALIDATE_IP);

        $this->info('Current interface IP: '.$currentInterfaceIp);

        if ($cachedIp === $currentInterfaceIp) {
            dd('DNS record is up to date!');
            $this->info('DNS record is up to date!');

            return;
        }

        if ($dnsRecord->interface_ip === $currentInterfaceIp) {
            $this->info('Setting the DNS record to the virtual IP...');
            $this->setDnsRecordToVirtualIp($dnsRecord);
            $this->info('DNS record updated!');

            return;
        }

        $this->info('Setting the DNS record to the interface IP...');
        $this->setDnsRecordToInterfaceIp($dnsRecord, $currentInterfaceIp);
        $this->info('DNS record updated!');

    }

    /**
     * Set DNS record to interface IP.
     */
    private function setDnsRecordToInterfaceIp(CloudflareRecord $dnsRecord, string $currentInterfaceIp): void
    {
        $dns = $this->getZoneAndRecordId($dnsRecord)['dns'];
        $zoneId = $this->getZoneAndRecordId($dnsRecord)['zoneId'];
        $recordId = $this->getZoneAndRecordId($dnsRecord)['recordId'];

        $dns->updateRecordDetails($zoneId, $recordId, [
            'content' => $currentInterfaceIp,
            'proxied' => $dnsRecord->proxy,
            'type' => 'A',
            'name' => $dnsRecord->fqdn,
        ]);

        $dnsRecord->update([
            'cached_ip' => $currentInterfaceIp,
        ]);

        if (config('features.send-emails')) {
            $this->info('Sending email...');
            Mail::to($dnsRecord->owner)->send(new CloudflareRecordUpdated($dnsRecord));
            $this->info('Email sent!');
        }

    }

    /**
     * Set DNS record to virtual IP.
     */
    private function setDnsRecordToVirtualIp(CloudflareRecord $dnsRecord): void
    {

        // dd($this->getZoneAndRecordId($dnsRecord));
        $dns = $this->getZoneAndRecordId($dnsRecord)['dns'];
        $zoneId = $this->getZoneAndRecordId($dnsRecord)['zoneId'];
        $recordId = $this->getZoneAndRecordId($dnsRecord)['recordId'];

        $dns->updateRecordDetails($zoneId, $recordId, [
            'content' => $dnsRecord->virtual_ip,
            'proxied' => $dnsRecord->proxy,
            'type' => 'A',
            'name' => $dnsRecord->fqdn,
            'ttl' => null,
        ]);

        $dnsRecord->update([
            'cached_ip' => $dnsRecord->virtual_ip,
        ]);

        if (config('features.send-emails')) {
            $this->info('Sending email...');
            Mail::to($dnsRecord->owner)->send(new CloudflareRecordUpdated($dnsRecord));
            $this->info('Email sent!');
        }

    }

    private function getZoneAndRecordId(CloudflareRecord $dnsRecord)
    {
        $token = new APIToken($dnsRecord->token);
        $adapter = new \Cloudflare\API\Adapter\Guzzle($token);
        $zone = new \Cloudflare\API\Endpoints\Zones($adapter);
        $zoneId = $zone->getZoneID($dnsRecord->domain);
        $dns = new \Cloudflare\API\Endpoints\DNS($adapter);
        $recordId = $dns->getRecordID($zoneId, 'A', $dnsRecord->fqdn);

        return [
            'zoneId' => $zoneId,
            'recordId' => $recordId,
            'dns' => $dns,
        ];
    }

    /**
     * Get current interface IP.
     */
    private function getCurrentInterfaceIp(): string
    {
        $ip = Http::get('https://api.ipify.org')->body();

        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
        }
        exit(-1);
    }
}
