<div wire:poll.10s class="mt-2">
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        {{ __('User') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Enclosure') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Station') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Vote') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Options') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $record->user->name }}
                        </th>
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $record->station->enclosure->name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $record->station->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $record->votes->sum('amount') }}
                        </td>
                        <td class="px-6 py-4">
                            <ul>
                                <li>
                                    <a href="{{ Storage::url($record->image) }}" download>
                                        {{ __('Download') }}
                                    </a>
                                </li>
                                @if ($record->is_approved == false)
                                    <li>
                                        <a wire:click='showApproved({{ $record->id }})'
                                            class="font-medium capitalize text-blue-600 dark:text-blue-500 hover:underline cursor-pointer">
                                            {{ __('Approved') }}
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('checker.station-votes', $record) }}" class="font-medium capitalize text-green-600 dark:text-green-500 hover:underline cursor-pointer">
                                            {{ __('View') }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-2">
            {{ $records->links() }}
        </div>
    </div>

    <flux:modal name="tracking-approved" class="md:w-120">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Approved record') }}</flux:heading>
                <flux:subheading>{{ __('Once approved, no modifications can be made.') }}</flux:subheading>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:button wire:click='closeApproved' variant="primary">{{ __('Cancel') }}</flux:button>
                <flux:button wire:click='approved'>{{ __('Accept') }}</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
