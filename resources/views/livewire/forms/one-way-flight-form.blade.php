<div>
    <div class="relative -mt-[24px]">
        <form wire:submit="next" class="space-y-6">
            <div class="text-right absolute -top-[39px] right-0 hidden sm:block">
                <x-filament::button wire:click="resetForm" size="sm">{{ __('Reset All') }}</x-filament::button>
            </div>
            <div class="step-1-form bg-primary-600 rounded-xl p-4 md:p-6 rounded-t-none shadow">
                {{ $this->form }}

                <div class="absolute top-[9%] -translate-y-[9%] left-[50%] -translate-x-[50%] md:left-[33.1%] md:-translate-x-[33.1%] md:top-[15%] md:-translate-y-[15%] lg:top-[20%] lg:-translate-y-[20%]">
                    <x-filament::button wire:click="swap" icon="heroicon-o-arrows-right-left" size="xs" color="gray"></x-filament::button>
                </div>
            </div>
            <div class="mt-2">
                <livewire:flight.add-options flight_type="oneway" id="primary" />
            </div>
            <div class="flex items-center justify-end flex-wrap gap-3">
                <x-filament::button wire:click="share" size="lg" type="button" icon="heroicon-o-share" outlined>{{ __('Share') }}</x-filament::button>
                <x-filament::button size="lg" type="submit">{{ __('Next') }}</x-filament::button>
            </div>
        </form>
    </div>

    <x-filament-actions::modals />
</div>
