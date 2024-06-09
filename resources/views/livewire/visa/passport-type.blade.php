<x-filament::modal id="add-passport-type-modal">
    <x-slot name="heading">
        {{ __('Passport Type')}}
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </x-slot>
    <div class="space-y-4">
        <p class="fw-semibold"><b>{{ __('Choose purpose') }}:</b></p>
        @foreach($passport_types as $id => $type)
        <div class="form-check">
            <input class="form-check-input" type="radio" name="passport_type" id="{{ $id }}" wire:click="type('{{ $id }}', '{{ $type }}')">
            <label class="form-check-label" for="{{ $id }}">
                {{ $type }}
            </label>
        </div>
        @endforeach
    </div>
    <x-slot name="footerActions">
        <x-filament::button wire:click="next" class="w-full" data-bs-dismiss="modal">Next</x-filament::button>
    </x-slot>
</x-filament::modal>