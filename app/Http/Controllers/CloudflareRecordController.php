<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCloudflareRecordRequest;
use App\Http\Requests\UpdateCloudflareRecordRequest;
use App\Models\CloudflareRecord;

class CloudflareRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard', [
            'cloudflareRecords' => CloudflareRecord::where('team_id', auth()->user()->currentTeam->id)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cloudflare-records.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCloudflareRecordRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CloudflareRecord $cloudflareRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CloudflareRecord $cloudflareRecord)
    {
        return view('cloudflare-records.edit', [
            'cloudflareRecord' => $cloudflareRecord,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCloudflareRecordRequest $request, CloudflareRecord $cloudflareRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CloudflareRecord $cloudflareRecord)
    {

        $cloudflareRecord->delete();

        session()->flash('flash.banner', 'Cloudflare record deleted.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('dashboard');
    }
}
