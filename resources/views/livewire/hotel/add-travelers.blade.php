<x-filament::modal id="add-travelers-modal">
    <x-slot name="heading">
        {{ __('Travelers') }}
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </x-slot>
    <div class="space-y-4">
        <p class="fw-semibold"><b>{{ __('No of travelers') }}</b></p>
        <label for='name'
            style="display: flex; align-items: center;"><span><b>Adult</b></span>
            <span style="margin-left: auto;">
                <img src="{{ asset('assets/icons/sign.png') }}" alt="Icon Description" wire:click="decrementAdults">
                <span style="margin: 0px 4px;text-align: center;">
                    {{ $adults }}
                </span>
                <img src="{{ asset('assets/icons/plus.png') }}" alt="Icon Description" wire:click="incrementAdults">
            </span>
        </label>
        <hr>
        <label for='name' style="display: flex; align-items: center;"><span><b>Child</b>
                <span class="p-style-sub">(Age 2-11)</span>
            </span>
            <span style="margin-left: auto;">
                <img src="{{ asset('assets/icons/sign.png') }}" alt="Icon Description" wire:click="decrementChildren">
                <span style="margin: 0px 4px;text-align: center;">
                    {{ $children }}
                </span>
                <img src="{{ asset('assets/icons/plus.png') }}" alt="Icon Description" wire:click="incrementChildren">
            </span>
        </label>
        <hr>
        <label for='name' style="display: flex; align-items: center;"><span><b>Infant</b>
                <span class="p-style-sub">(Under 2)</span>
            </span>
            <span style="margin-left: auto;">
                <img src="{{ asset('assets/icons/sign.png') }}" alt="Icon Description" wire:click="decrementInfants">
                <span style="margin: 0px 4px;text-align: center;">
                    {{ $infants }}
                </span>
                <img src="{{ asset('assets/icons/plus.png') }}" alt="Icon Description" wire:click="incrementInfants">
            </span>
        </label>
    </div>
    <x-slot name="footerActions">
        <x-filament::button wire:click="next" class="w-full" data-bs-dismiss="modal">Next</x-filament::button>
    </x-slot>
</x-filament::modal>