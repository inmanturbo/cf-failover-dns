<?php

use App\Http\Controllers\CloudflareRecordController;
use App\Models\CloudflareRecord;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [CloudflareRecordController::class, 'index'])
        ->name('dashboard')
        ->can('viewAny', CloudflareRecord::class);

    Route::post('/cloudflare-records', [CloudflareRecordController::class, 'store'])
        ->name('cloudflare-records.store')
        ->can('create', CloudflareRecord::class);

    Route::get('/cloudflare-records/create', [CloudflareRecordController::class, 'create'])
        ->name('cloudflare-records.create')
        ->can('create', CloudflareRecord::class);

    Route::get('/cloudflare-records/{cloudflareRecord}/edit', [CloudflareRecordController::class, 'edit'])
        ->name('cloudflare-records.edit')
        ->can('update', 'cloudflareRecord');

    Route::put('/cloudflare-records/{cloudflareRecord}', [CloudflareRecordController::class, 'update'])
        ->name('cloudflare-records.update')
        ->can('update', 'cloudflareRecord');

    Route::delete('/cloudflare-records/{cloudflareRecord}', [CloudflareRecordController::class, 'destroy'])
        ->name('cloudflare-records.destroy')
        ->can('delete', 'cloudflareRecord');
});
