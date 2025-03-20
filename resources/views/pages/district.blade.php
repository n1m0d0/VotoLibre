<x-layouts.app title="{{ __('Districts') }}">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Districts') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the districts of system') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @livewire('component-district')
</x-layouts.app>
