<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Inertia\Inertia;

class QueueController extends Controller
{
    public function failedJobs(Request $request)
    {
        $failed = collect();
        $connection = config('queue.default');

        if ($connection === 'database') {
            $failed = \Illuminate\Database\Facades\DB::table('failed_jobs')
                ->latest()
                ->paginate(20)
                ->withQueryString()
                ->through(fn ($job) => (object) [
                    'id' => $job->id,
                    'queue' => $job->queue,
                    'payload' => json_decode($job->payload, true),
                    'exception' => $job->exception,
                    'failed_at' => $job->failed_at,
                ]);
        }

        return Inertia::render('Admin/Queue/FailedJobs', [
            'failedJobs' => $failed,
        ]);
    }

    public function retryJob(Request $request, string $id)
    {
        Queue::connection(config('queue.default'))->retry($id);

        return back()->with('success', 'Job retried successfully.');
    }

    public function deleteJob(Request $request, string $id)
    {
        \Illuminate\Database\Facades\DB::table('failed_jobs')->where('id', $id)->delete();

        return back()->with('success', 'Failed job deleted successfully.');
    }
}
