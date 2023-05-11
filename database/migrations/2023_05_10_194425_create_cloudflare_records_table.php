<?php

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cloudflare_records', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Team::class)->constrained();
            $table->string('token');
            $table->string('hostname')->default('@');
            $table->string('domain');
            $table->string('interface_ip');
            $table->string('cached_ip')->nullable();
            $table->string('virtual_ip');
            $table->boolean('proxy')->default('false');
            $table->text('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cloudflare_records');
    }
};
