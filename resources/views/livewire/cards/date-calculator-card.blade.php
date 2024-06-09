<div>
    <div x-cloak wire:ignore.self id="date-calculator-popup" class="w-screen h-screen fixed top-0 right-0 z-[9999] hidden">
        <div class="absolute w-full h-full bg-primary-600/80 backdrop-blur-sm z-[9999]"></div>
        <div class="absolute z-[9999] w-[80%] sm:w-[70%] md:w-[60%] lg:w-[500px] top-[50%] left-[50%] -translate-x-[50%] -translate-y-[50%]">
            <div class="w-full rounded-lg shadow bg-zinc-100 shadow">
                <div class="border-b flex justify-between items-center border-b bg-white rounded-t-lg p-4">
                    <h1 class="text-lg font-medium text-zinc-800">{{ __('Date Calculator') }}</h1>
                    <x-filament::icon-button id="date-calculator-popup-close-btn" icon="heroicon-o-x-circle" color="danger" />
                </div>
                <div class="px-4 pt-6 pb-8">
                    {{$this->form}}
                </div>
                <div class="flex justify-between bg-white rounded-b-lg border-t p-4">
                    <x-filament::button wire:click="clear" icon="heroicon-o-x-circle" color="danger">{{ __('Clear') }}</x-filament::button>
                </div>
            </div>
        </div>
    </div>
    <x-filament::button id="date-calculator-popup-btn" size="xl" icon="heroicon-o-calendar-days">{{ __('Date Calculator') }}</x-filament::button>
</div>
