<div class="mb-4 border p-4 rounded">
    <div class="flex items-center justify-between">
        <div>
            {{ $vote->party->name }}
        </div>

        <div class="flex items-center space-x-2">
            @if ($editing)
                <flux:input type="number" wire:model.defer="amount" min="0" />

                <flux:button wire:click="save">{{ __('Save') }}</flux:button>
                <flux:button wire:click="cancelEdit" variant="danger">{{ __('Cancel') }}</flux:button>
            @else
                <span class="text-lg">{{ $amount }}</span>
                <flux:button wire:click="startEditing" variant="primary">{{ __('Edit') }}</flux:button>
            @endif
        </div>
    </div>
</div>
