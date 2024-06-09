<div>
    <form wire:submit="save">
        {{ $this->form }}
        <br>
        <x-filament::button type="submit" form="create" class="text-lg px-6 py-3">
            {{ __('Submit') }}
        </x-filament::button>
    </form>
    <x-filament-actions::modals />
</div>
