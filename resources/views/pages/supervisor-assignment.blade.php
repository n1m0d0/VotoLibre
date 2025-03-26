<x-layouts.app title="{{ __('Supervisors assignment') }}">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Supervisors assignment') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the supervisors assignment of system') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @livewire('component-supervisor-assignment')
</x-layouts.app>