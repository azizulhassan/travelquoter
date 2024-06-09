<x-filament::modal id="add-no-of-visit-modal">
    <x-slot name="heading">
        {{ __('No of visits') }}
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </x-slot>
    <div class="space-y-4">
        <p class="fw-semibold"><b>{{ __('Choose') }}:</b></p>
        @foreach($no_of_visits as $slug => $number)
        <div class="form-check">
            <input class="form-check-input" type="radio" name="no_of_visits" id="{{ $slug }}" wire:change="selectNumber('{{ $number }}')">
            <label class="form-check-label" for="{{ $slug }}">
                {{ $number }}
            </label>
        </div>
        @endforeach
    </div>
    <x-slot name="footerActions">
        <x-filament::button wire:click="next" class="w-full" data-bs-dismiss="modal">Next</x-filament::button>
    </x-slot>
</x-filament::modal>