<?php

namespace App\Jobs;

use App\Events\TestEventFired;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAsync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $sync_id,
        public int $num,
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        TestEventFired::fire(sync_id: $this->sync_id, num: $this->num);
    }
}
