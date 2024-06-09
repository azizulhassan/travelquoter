<div>
    <form wire:submit="save">
        <div>
            {{ $this->form }}
        </div>
        <x-filament::button type="submit" form="save" class="px-6 mt-10">
           {{ __('Submit') }}
        </x-filament::button>
    </form>
</div>