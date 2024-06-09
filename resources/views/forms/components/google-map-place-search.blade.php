<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">

    <input class="w-full bg-white" wire:model.live="{{ $getStatePath() }}" />

    {{-- <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        <!-- Interact with the `state` property in Alpine.js -->
    </div> --}}
</x-dynamic-component>
