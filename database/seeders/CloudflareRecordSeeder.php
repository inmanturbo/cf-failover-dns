<?php

namespace Database\Seeders;

use App\Models\CloudflareRecord;
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
