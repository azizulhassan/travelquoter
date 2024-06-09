<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
    :id="$getId()"
>

    <div class="full-input input-car-row-2" @click="$dispatch('open-modal', { id: 'add-purpose-of-visit-modal' })" >
        <label for="name" style="display: flex; align-items: center;">
            <span>{{ __('Visit purpose') }}:{{ $this->visit_purpose_string }}</span> 
            <img src="{{ asset('assets/icons/down.png') }}" alt="Icon Description" style="margin-left: auto;">
        </label>
    </div>
</x-dynamic-component>