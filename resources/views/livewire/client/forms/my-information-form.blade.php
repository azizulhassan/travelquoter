<div>
    <form wire:submit="update">
        <div>
            {{ $this->form }}
        </div>
        <div class="mt-4">
            <x-filament::button size="lg" type="submit" color="primary">{{ __('Update Information') }}</x-filament::button>
        </div>
    </form>
</div>
