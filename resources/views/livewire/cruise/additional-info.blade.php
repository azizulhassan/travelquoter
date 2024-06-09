<x-filament::modal id="cruise-additional-info">
    <x-slot name="heading">
        {{ __('Additional Information') }}
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </x-slot>
    <div class="space-y-4">
        <p class="fw-semibold"><b>{{ __('Choose Properties') }}</b></p>
        @foreach($this->additionalInfo as $key => $info)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="{{ $key }}" id="{{ $key }}" wire:change="toggle('{{ $info }}', $event.target.checked)" @if(array_search($info, $this->selectedInfo)) checked @endif>
                <label class="form-check-label" for="flexRadioDefault1">
                    {{ $info }}
                </label>
            </div>
        @endforeach
    </div>
    <x-slot name="footerActions">
        <x-filament::button wire:click="next" class="w-full" data-bs-dismiss="modal">Next</x-filament::button>
    </x-slot>
</x-filament::modal>