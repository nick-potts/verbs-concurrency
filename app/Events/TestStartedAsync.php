<?php

namespace App\Events;

use App\Jobs\ProcessReactAsync;
use App\States\SyncState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class TestStartedAsync extends Event
{
    public function __construct(
        #[StateId(SyncState::class)]
        public int|null $sync_id
    )
    {
    }

    public function apply(SyncState $state): void
    {
        $state->requested_count = 1000;
    }

    public function handle(SyncState $state): string
    {
        ProcessReactAsync::dispatch($this->sync_id);
        return $state->id;
    }
}
