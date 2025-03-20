<x-layouts.app title="{{ __('Positions') }}">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Positions') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the positions of system') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @livewire('component-position')
</x-layouts.app>
