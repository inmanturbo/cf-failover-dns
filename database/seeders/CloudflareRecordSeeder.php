<?php

namespace Database\Seeders;

use App\Models\CloudflareRecord;
use BaconQrCode\Renderer\Path\Close;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CloudflareRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CloudflareRecord::factory()->count(10)->create();
    }
}
