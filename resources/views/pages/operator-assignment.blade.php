<x-layouts.app title="{{ __('Operators assignment') }}">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Operators assignment') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the operators assignment of system') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @livewire('component-operator-assignment')
</x-layouts.app>