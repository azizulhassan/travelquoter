<div>
    <div class="space-y-4">
        @foreach ($data as $key => $item)
            <div wire:key="{{$key}}">
                <livewire:subtesting-comp :key="$key" :id="$key" />
                <x-filament::button wire:click="remove({{ $key }})" size="xs" color="danger">Close</x-filament::button>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        <x-filament::button wire:click="addDestination">Add More Destination</x-filament::button>
    </div>
</div>
