<x-layouts.app title="{{ __('Parties') }}">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Parties') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the parties of system') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @livewire('component-party')
</x-layouts.app>
