<x-layouts.app title="{{ __('Zones') }}">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Zones') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the zones of system') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @livewire('component-zone')
</x-layouts.app>
