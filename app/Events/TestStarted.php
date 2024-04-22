<?php

namespace App\Events;

use App\Jobs\ProcessAsync;
use App\Models\Sync;
use App\States\SyncState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;
use Thunk\Verbs\Facades\Verbs;

class TestStarted extends Event
{
    public function __construct(
        #[StateId(SyncState::class)]
        public int|null $sync_id
    )
    {
    }

    public function apply(SyncState $state): void
    {
        $state->requested_count = 1001;
    }

    public function handle(SyncState $state): int
    {
        Verbs::unlessReplaying(function () use ($state) {
            for ($i = 0; $i < $state->requested_count; $i++) {
                dispatch(new ProcessAsync(sync_id: $state->id, num: $i));
            }
        });
        return $this->sync_id;
    }
}
