<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
    :id="$getId()"
>

    <div class="full-input input-hotel-row-2" @click="$dispatch('open-modal', { id: 'add-accomodation-type-modal' })" >
        <label for="name" style="display: flex; align-items: center;">
            <span>{{ __('Accommodation type') }}:{{ $this->accommodation_type_string }}</span> 
            <img src="{{ asset('assets/icons/down.png') }}" alt="Icon Description" style="margin-left: auto;">
        </label>
    </div>
</x-dynamic-component>