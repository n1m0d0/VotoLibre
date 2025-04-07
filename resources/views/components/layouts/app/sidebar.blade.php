<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    @persist('toast')
        <livewire:toasts />
    @endpersist

    <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="home" :href="route('dashboard')"
                    :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}
                </flux:navlist.item>

                <flux:navlist.item icon="presentation-chart-line" :href="route('chart')"
                    :current="request()->routeIs('')" wire:navigate>{{ __('Chart') }}
                </flux:navlist.item>
            </flux:navlist.group>

            @role('administrator')
                <flux:navlist.group :heading="__('Administration')" class="grid">
                    <flux:navlist.item icon="user" :href="route('admin.user')"
                        :current="request()->routeIs('admin.user')" wire:navigate>{{ __('Users') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="globe-alt" :href="route('admin.department')"
                        :current="request()->routeIs('admin.department')" wire:navigate>{{ __('Departments') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="globe-americas" :href="route('admin.province')"
                        :current="request()->routeIs('admin.province')" wire:navigate>{{ __('Provinces') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="globe-asia-australia" :href="route('admin.municipality')"
                        :current="request()->routeIs('admin.municipality')" wire:navigate>{{ __('Municipalities') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="globe-europe-africa" :href="route('admin.district')"
                        :current="request()->routeIs('admin.district')" wire:navigate>{{ __('Districts') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="map" :href="route('admin.zone')"
                        :current="request()->routeIs('admin.zone')" wire:navigate>{{ __('Zones') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="building-office-2" :href="route('admin.enclosure')"
                        :current="request()->routeIs('admin.enclosure')" wire:navigate>{{ __('Enclosures') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="archive-box" :href="route('admin.station')"
                        :current="request()->routeIs('admin.station')" wire:navigate>{{ __('Stations') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="identification" :href="route('admin.party')"
                        :current="request()->routeIs('admin.party')" wire:navigate>{{ __('Parties') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="briefcase" :href="route('admin.position')"
                        :current="request()->routeIs('admin.position')" wire:navigate>{{ __('Positions') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            @endrole

            @role('supervisor|administrator')
                <flux:navlist.group :heading="__('Supervision')" class="grid">
                    <flux:navlist.item icon="user-group" :href="route('super.supervisor-assignment')"
                        :current="request()->routeIs('super.supervisor-assignment')" wire:navigate>{{ __('Supervisors assignment') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="users" :href="route('super.operator-assignment')"
                        :current="request()->routeIs('super.operator-assignment')" wire:navigate>{{ __('Operators assignment') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            @endrole

            @role('checker|administrator')
                <flux:navlist.group :heading="__('Control')" class="grid">
                    <flux:navlist.item icon="eye" :href="route('checker.tracking')"
                        :current="request()->routeIs('checker.tracking')" wire:navigate>{{ __('Tracking') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            @endrole
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">

        </flux:navlist>

        <!-- Desktop User Menu -->
        <flux:dropdown position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon-trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-left text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-left text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @fluxScripts
    @stack('scripts')
</body>

</html>
