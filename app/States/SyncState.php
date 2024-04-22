<?php

namespace App\States;

use Thunk\Verbs\State;

class SyncState extends State
{
    public int $count = 0;
    public string $order = '';
    public int $requested_count = 0;
}
