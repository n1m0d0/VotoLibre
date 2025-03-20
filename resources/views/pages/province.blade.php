<x-layouts.app title="{{ __('Provinces') }}">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Provinces') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the provinces of system') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @livewire('component-province')
</x-layouts.app>
