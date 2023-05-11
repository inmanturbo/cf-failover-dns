<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CloudflareRecord>
 */
class CloudflareRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'token' => $this->faker->sha256,
            'hostname' => $this->faker->domainWord,
            'domain' => $this->faker->domainName,
            'interface_ip' => $this->faker->ipv4,
            'cached_ip' => $this->faker->ipv4,
            'virtual_ip' => $this->faker->ipv4,
            'proxy' => $this->faker->boolean,
            'data' => [
                'foo' => 'bar',
            ],
            'team_id' => 1,
        ];
    }
}
