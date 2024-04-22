<?php

namespace App\Events;

use App\Models\Sync;
use App\Models\SyncEvents;
use App\States\SyncState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class TestEventFired extends Event
{
    public function __construct(
        #[StateId(SyncState::class)]
        public int|null $sync_id,
        public int $num
    )
    {
    }

    public function apply(SyncState $state): void
    {
        $state->count++;
        $state->order .= "$this->num, ";
    }

    public function handle(SyncState $state): void
    {
        SyncEvents::upsert([
            'id' => $this->num,
            'sync_id' => $this->sync_id
        ],
        ['id', 'sync_id']);

        $count = SyncEvents::where('sync_id', $this->sync_id)->count();
        $done = ($count === $state->requested_count);

        Sync::upsert([
            'id' => $this->sync_id,
            'order' => $state->order,
            'count' => $state->count,
            'actual_count' => $count,
            'requested_count' => $state->requested_count,
        ], [
            'id'
        ]);

    }
}
