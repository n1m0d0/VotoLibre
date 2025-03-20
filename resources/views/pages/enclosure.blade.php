<x-layouts.app title="{{ __('Enclosures') }}">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Enclosures') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the enclosures of system') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @livewire('component-enclosure')
</x-layouts.app>
