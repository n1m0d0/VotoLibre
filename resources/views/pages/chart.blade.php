<x-layouts.app title="{{ __('Charts') }}">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Charts') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('the charts of system') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @livewire('component-chart')
</x-layouts.app>
