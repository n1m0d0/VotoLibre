<div wire:poll.10s class="p-4">
    <a href="{{ route('checker.tracking') }}"
        class="flex items-center space-x-2 font-medium capitalize text-blue-600 dark:text-blue-500 hover:underline cursor-pointer mb-4">
        <flux:icon.arrow-uturn-left />
        <span>{{ __('Back') }}</span>
    </a>


    <h2 class="text-xl text-white font-bold">{{ __('User') }}: <span
            class="text-lg text-gray-400 uppercase">{{ $record->user->name }}</span></h2>
    <h2 class="text-xl text-white font-bold">{{ __('Enclosure') }}: <span
            class="text-lg text-gray-400 uppercase">{{ $record->station->enclosure->name }}</span></h2>
    <h2 class="text-xl text-white font-bold">{{ __('Station') }}: <span
            class="text-lg text-gray-400 uppercase">{{ $record->station->name }}</span></h2>

    @foreach ($record->votes as $vote)
        @livewire('component-vote-editor', ['vote' => $vote], key($vote->id))
    @endforeach
</div>
