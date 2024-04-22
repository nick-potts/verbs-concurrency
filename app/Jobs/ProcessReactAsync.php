<?php

namespace App\Jobs;

use App\Events\TestEventFired;
use App\States\SyncState;
use Clue\React\Mq\Queue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use function React\Async\async;

class ProcessReactAsync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $state_id
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $state = SyncState::load($this->state_id);
        $ids = range(0, $state->requested_count-1);
        Queue::all(10, $ids, fn(int $id) =>
        async(fn() =>
            TestEventFired::fire(sync_id: $state->id, num: $id)
        )());
    }
}
