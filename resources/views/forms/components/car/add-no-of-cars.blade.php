<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div class='full-input input-car-row-2'><label for='name' style="display: flex; align-items: center;" @click="$dispatch('open-modal', { id: 'add-car-type-modal' })">
        <span>No. of cars: {{ $this->no_of_cars }}</span> 
        <img src="{{ asset('assets/icons/down.png') }}" alt="Icon Description" style="margin-left: auto;">
    </label>
    </div>
</x-dynamic-component>

<livewire:car.add-car-type />