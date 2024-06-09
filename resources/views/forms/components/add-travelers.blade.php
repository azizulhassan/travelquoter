<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
    :id="$getId()"
>

    <div class="full-input input-cruises-row-2" @click="$dispatch('open-modal', { id: 'add-travelers-modal' })" >
        <label for="name" style="display: flex; align-items: center;">
            <span>Travelers number &amp; age:03</span> 
            <img src="{{ asset('assets/icons/down.png') }}" alt="Icon Description" style="margin-left: auto;">
        </label>
    </div>
</x-dynamic-component>

<livewire:insurance.add-travelers />