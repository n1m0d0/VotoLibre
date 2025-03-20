<x-layouts.app title="{{ __('Departments') }}">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Departments') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the departments of system') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @livewire('component-department')
</x-layouts.app>
