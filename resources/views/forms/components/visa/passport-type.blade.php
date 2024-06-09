<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
    :id="$getId()"
>

    {{-- <div class="full-input input-car-row-2" @click="$dispatch('open-modal', { id: 'add-passport-type-modal' })" >
        <label for="name" style="display: flex; align-items: center;">
            <span>{{ __('Passport type') }}:{{ $this->passport_type }}</span> 
            <img src="{{ asset('assets/icons/down.png') }}" alt="Icon Description" style="margin-left: auto;">
        </label>
    </div> --}}
    <div class="full-input">
        <label for="name"><img src="{{ asset('assets/icons/calendar.png') }}" alt="Icon Description"> {{ __('Passport Type') }}</label>
        <input type="text" class="input-visa-row-1" name="name" readonly @click="$dispatch('open-modal', { id: 'add-passport-type-modal' })" value="{{ $this->passport_type }}">
    </div>
</x-dynamic-component>