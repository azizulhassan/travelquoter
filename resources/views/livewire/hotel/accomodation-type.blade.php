<x-filament::modal id="add-accomodation-type-modal">
    <x-slot name="heading">
        {{ __('Accomodation Type') }}
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </x-slot>
    <div class="space-y-4">
        <p class="fw-semibold"><b>{{ __('Select accomodation type') }}:</b></p>
        @foreach($types as $slug => $type)
            <div class="form-check">
                <input wire:change="toggle('{{ $type }}', $event.target.checked)" class="form-check-input" type="checkbox" name="{{ $slug }}" id="{{ $slug }}">
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