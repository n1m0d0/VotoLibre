<x-layouts.app title="{{ __('Tracking') }}">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Tracking') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the Tracking of system') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @livewire('component-tracking')
</x-layouts.app>