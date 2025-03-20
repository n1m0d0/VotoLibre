<x-layouts.app title="{{ __('Stations') }}">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Stations') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the stations of system') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @livewire('component-station')
</x-layouts.app>
