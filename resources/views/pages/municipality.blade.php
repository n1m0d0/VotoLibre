<x-layouts.app title="{{ __('Municipalities') }}">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Municipalities') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the municipalities of system') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @livewire('component-municipality')
</x-layouts.app>
