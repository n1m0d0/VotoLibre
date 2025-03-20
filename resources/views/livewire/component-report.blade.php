<div class="grid auto-rows-min gap-4 md:grid-cols-3">
    <div
        class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex items-center p-8 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900 dark:to-indigo-900 shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="flex-shrink-0 mr-8">
            <flux:icon.globe-europe-africa class="w-24 h-24 text-blue-500 dark:text-blue-300" />
        </div>

        <div class="flex-grow">
            <p class="text-xl font-semibold text-neutral-700 dark:text-neutral-200 mb-2">
                {{ __('Districts') }}
            </p>

            <p class="text-4xl bg-gray-700 dark:bg-white rounded-full font-bold text-center text-white dark:text-black">
                {{ $districts->count() }}
            </p>
        </div>
    </div>
    <div
        class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex items-center p-8 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900 dark:to-indigo-900 shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="flex-shrink-0 mr-8">
            <flux:icon.map class="w-24 h-24 text-blue-500 dark:text-blue-300" />
        </div>

        <div class="flex-grow">
            <p class="text-xl font-semibold text-neutral-700 dark:text-neutral-200 mb-2">
                {{ __('Zones') }}
            </p>

            <p class="text-4xl bg-gray-700 dark:bg-white rounded-full font-bold text-center text-white dark:text-black">
                {{ $zones->count() }}
            </p>
        </div>
    </div>
    <div
        class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex items-center p-8 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900 dark:to-indigo-900 shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="flex-shrink-0 mr-8">
            <flux:icon.building-office-2 class="w-24 h-24 text-blue-500 dark:text-blue-300" />
        </div>

        <div class="flex-grow">
            <p class="text-xl font-semibold text-neutral-700 dark:text-neutral-200 mb-2">
                {{ __('Enclosures') }}
            </p>

            <p class="text-4xl bg-gray-700 dark:bg-white rounded-full font-bold text-center text-white dark:text-black">
                {{ $enclosures->count() }}
            </p>
        </div>
    </div>

    <div>
        <flux:button wire:click='enclosuresExport'>{{ __('Enclosures Export') }}</flux:button>
    </div>
</div>
