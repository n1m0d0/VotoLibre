<x-layouts.app title="Dashboard">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Reports') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Viewing system data') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @livewire('component-report')


</x-layouts.app>
