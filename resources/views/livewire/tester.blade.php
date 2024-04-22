<?php
use Livewire\Volt\Component;

new class extends Component {
    #[\Livewire\Attributes\Url(history: true)]
    public ?int $sync_id = null;

    public function dispatch_sync(): void
    {
        $this->sync_id = \App\Events\TestStarted::commit(sync_id: null);
        $this->redirect('/?sync_id=' . $this->sync_id);
    }

    #[\Livewire\Attributes\Computed]
    public function status(): ?\App\Models\Sync
    {
        return \App\Models\Sync::find($this->sync_id);
    }

    #[\Livewire\Attributes\Computed]
    public function syncId(): ?int
    {
        return $this->sync_id;
    }
} ?>

<div class="bg-gray-100 p-6 rounded-lg shadow-lg max-w-4xl mx-auto my-4">
    <div class="flex justify-between items-center mb-4">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" wire:click="dispatch_sync">
            Dispatch process
        </button>
        <p class="text-lg font-semibold text-black">
            Be sure to run horizon
        </p>
    </div>
    <div class="bg-black p-4 rounded-lg shadow-md text-white" wire:poll.500ms>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <p class="text-sm">Requested Count:</p>
                <p class="text-lg font-semibold text-green-500">{{ $this->status?->requested_count }}</p>
            </div>
            <div>
                <p class="text-sm">Observed Count:</p>
                <p class="text-lg font-semibold text-green-500">{{ $this->status?->actual_count }}</p>
            </div>
            <div>
                <p class="text-sm">State Count:</p>
                <p class="text-lg font-semibold text-blue-500">{{ $this->status?->count }}</p>
            </div>
            <div>
                <p class="text-sm">Status:</p>
                <p class="text-lg font-semibold" :class="{'text-red-500': {{ $this->status?->requested_count }} !== {{ $this->status?->actual_count }}, 'text-green-500': {{ $this->status?->actual_count }} === {{ $this->status?->count }}">
                    {{ ($this->status?->requested_count === $this->status?->actual_count) ? 'Complete' : 'In Progress' }}
                </p>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-sm">State recorded order:</p>
            <p class="text-sm overflow-auto" style="min-height: 150px;">{{ $this->status?->order }}</p>
        </div>
    </div>
</div>


