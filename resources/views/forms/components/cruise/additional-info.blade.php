<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
    :id="$getId()"
>
    <div class='full-input input-cruises-row-2' @click="$dispatch('open-modal', { id: 'cruise-additional-info' })">
        <label for='name' style="display: flex; align-items: center;">
            <span>{{ __('Additional Info') }}:{{ $this->additionalInfo }}</span> 
            <img src="{{ asset('assets/icons/down.png') }}" alt="Icon Description" style="margin-left: auto;">
        </label>
    </div>
</x-dynamic-component>

<livewire:cruise.additional-info />