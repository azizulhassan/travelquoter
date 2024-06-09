<div>
    <form wire:submit="save">
        <div class="flex">
            <div class="border rounded-l-xl bg-white p-8">
                {{ $this->form }}
            </div>
            <div class="hidden md:block">
                <img class="h-full w-auto" src="{{ asset('uploads/contact_us_thumbnail.png') }}" alt="{{ __('Contact us') }}" />
            </div>
        </div>
        <br>
        <div class="flex justify-between flex-wrap items-center">
            <div>
                <x-filament::button tag="a" color="gray" href="{{ route('car.step-2') }}" size="lg">
                    {{ __('Go Back') }}
                </x-filament::button>
            </div>
            <div class="flex flex-wrap gap-x-3 items-center">
                <x-filament::button icon="heroicon-o-share" color="gray" size="lg">
                    {{ __('Share') }}
                </x-filament::button>

                <x-filament::button type="submit" size="lg">
                    {{ __('Get Quote') }}
                </x-filament::button>
            </div>
        </div>
    </form>
    <x-filament-actions::modals />
</div>
