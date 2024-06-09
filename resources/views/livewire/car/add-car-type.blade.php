<x-filament::modal id="add-car-type-modal">
    <x-slot name="heading">
        Car Type
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </x-slot>
    <div class="space-y-4">
        <p class="fw-semibold"><b>{{ __('Select car type') }}:</b></p>
        @foreach($carTypes as $slug => $type)
            <div class="form-check">
                <input wire:change="toggle('{{ $type }}', $event.target.checked)" class="form-check-input" type="checkbox" name="{{ $slug }}" id="{{ $slug }}" @if(array_search($type, $this->selectedCarTypes))) {{ 'checked' }} @endif>
                <label class="form-check-label" for="{{ $slug }}">
                    {{ $type }}
                </label>
            </div>
        @endforeach
        <p class="fw-semibold"><b>{{ __('No. of cars') }}:</b></p>
        <span style="">
            <img src="{{ asset('assets/icons/sign.png') }}" alt="Icon Description" wire:click="decreaseCars">
            <span style="margin: 0px 4px;text-align: center;">{{ $noOfCars }}</span>
            <img src="{{ asset('assets/icons/plus.png') }}" alt="Icon Description" wire:click="increaseCars">
        </span>
    </div>
    <x-slot name="footerActions">
        <x-filament::button wire:click="next" class="w-full" data-bs-dismiss="modal">Next</x-filament::button>
    </x-slot>
</x-filament::modal>