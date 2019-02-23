<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\FileResource;
use App\Http\Resources\SubscriptionResource;
use App\Models\File;
use App\Models\Subscription;

class ReportController extends ApiController
{
    public function getReport()
    {
        $report = [
            'imported'      => \App\Models\Profile::all()->count(),
            'files'         => FileResource::collection(File::all()),
            'subscriptions' => SubscriptionResource::collection(Subscription::all()),
            'big_files'     => FileResource::collection(File::where('profiles_count', '>', 400)->get()),
        ];

        return response()->json($report);
    }
}