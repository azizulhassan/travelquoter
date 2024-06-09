<x-filament::modal id="add-rooms-modal">
    <x-slot name="heading">
        {{ __('Rooms') }}
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </x-slot>
    <div class="space-y-4">
        <p class="fw-semibold"><b>{{ __('Select the number of bedrooms') }}:</b></p>
        @foreach($rooms as $slug => $room)
            <div class="form-check">
                <input wire:change="selectRoom('{{ $room }}', 'rooms')" class="form-check-input" type="radio" name="room_type" id="{{ $room }}" @if($this->selected_room == $room) {{ 'checked' }} @endif>
                <label class="form-check-label" for="{{ $room }}">
                    {{ $room }} {{ __ ('Bedroom') }}
                </label>
            </div>
        @endforeach
        <p class="fw-semibold"><b>{{ __('Select bed type') }}:</b></p>
        @foreach($bed_types as $slug => $type)
            <div class="form-check">
                <input wire:change="selectBedType('{{ $type }}', 'bed_types')" class="form-check-input" type="radio" name="bed_type" id="{{ $slug }}" @if($this->selected_bedtype == $type) {{ 'checked' }} @endif>
                <label class="form-check-label" for="{{ $slug }}">
                    {{ $type }}
                </label>
            </div>
        @endforeach
    </div>
    <x-slot name="footerActions">
        <x-filament::button wire:click="next" class="w-full" data-bs-dismiss="modal">Next</x-filament::button>
    </x-slot>
</x-filament::modal>