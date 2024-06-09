<div class="relative">
    <div class="text-right absolute -top-[39px] right-0 hidden sm:block">
        <x-filament::button wire:click="resetForm" size="sm">{{ __('Reset All') }}</x-filament::button>
    </div>

    @foreach ($multicity_flight_numbers as $key => $id)
        @if ($key == 0)
        <div wire:key="jsaghfk-{{ $id }}">
            <livewire:forms.one-way-flight-form-for-multi-city wire:key="multicity-{{ $id }}" flight_type="multi-city"
                identifier="{{ $id }}" />
        </div>
        @else
            <div wire:key="jsaghfk-{{ $id }}" class="multicity-flight-form-other mt-8 relative">
                <div class="absolute -top-2 -right-2 z-10">
                    <x-filament::icon-button wire:click="remove({{ $key }})" class="bg-red-200 p-1" color="danger" icon="heroicon-o-x-mark" />
                </div>
                <livewire:forms.one-way-flight-form-for-multi-city wire:key="multicity-{{ $id }}" flight_type="multi-city" identifier="{{ $id }}" />
            </div>
        @endif
    @endforeach
    
    <hr class="my-10" />

    <div>
        <x-filament::button wire:click="addDestination" icon="heroicon-o-plus" outlined>
            Add more Destination
        </x-filament::button>
    </div>

    <div>
        <div class="flex items-center justify-end flex-wrap gap-3">
            <x-filament::button id="fi-btn-outlined" @click="$clipboard('{{ url()->full() }}')" size="lg"
                type="button" icon="heroicon-o-share" outlined>{{ __('Share') }}</x-filament::button>
            <x-filament::button size="lg" type="submit" wire:click="next">{{ __('Next') }}</x-filament::button>
        </div>
    </div>
</div>
