<x-filament::modal id="add-purpose-of-visit-modal">
    <x-slot name="heading">
        {{ __('Visit Purpose')}}
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </x-slot>
    <div class="space-y-4">
        <p class="fw-semibold"><b>{{ __('Choose purpose') }}:</b></p>
        @foreach($purposes as $slug => $purpose)
        <div class="form-check">
            <input class="form-check-input" type="radio" name="purpose_of_visits" id="{{ $slug }}" wire:click="selectPurpose('{{ $slug }}', '{{ $purpose }}')">
            <label class="form-check-label" for="{{ $slug }}">
                {{ $purpose }}
            </label>
        </div>
        @endforeach
    </div>
    <x-slot name="footerActions">
        <x-filament::button wire:click="next" class="w-full" data-bs-dismiss="modal">Next</x-filament::button>
    </x-slot>
</x-filament::modal>