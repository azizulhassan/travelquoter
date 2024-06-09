<div>
    <form wire:submit="next" class="space-y-6">
        <div class="text-right">
            <x-filament::button wire:click="resetForm" size="sm">{{ __('Reset All') }}</x-filament::button>
        </div>
        <div class="step-1-form bg-primary-600 rounded-xl p-4 md:p-6 shadow border">
            {{ $this->form }}
        </div>
        <div class="flex items-center justify-end flex-wrap gap-3">
            {{-- @click="$clipboard('{{ url()->full() }}')"  --}}
            <x-filament::button wire:click="share" size="lg" type="button" icon="heroicon-o-share" outlined>{{ __('Share') }}</x-filament::button>
            <x-filament::button size="lg" type="submit">{{ __('Next') }}</x-filament::button>
        </div>
    </form>
</div>