<x-layouts.app title="{{ __('Station votes') }}">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Station votes') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the station votes of system') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @livewire('component-station-votes', ['record' => $record])
</x-layouts.app>