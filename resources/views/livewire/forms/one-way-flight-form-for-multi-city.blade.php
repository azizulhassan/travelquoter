<div>
    <div class="relative">
        <form wire:submit="next" class="space-y-6">
            <div class="step-1-form bg-primary-600 rounded-xl p-4 md:p-6 rounded-t-none shadow">
                {{ $this->form }}

                <div class="absolute top-[10%] -translate-y-[10%] left-[50%] -translate-x-[50%] md:left-[33.1%] md:-translate-x-[33.1%] md:top-[18%] md:-translate-y-[18%] lg:top-[25%] lg:-translate-y-[25%]">
                    <x-filament::button wire:click="swap" icon="heroicon-o-arrows-right-left" size="xs" color="gray"></x-filament::button>
                </div>
            </div>
            <div class="mt-2">
                {{ $this->addOptions }}
            </div>
        </form>
    </div>

    <div class="flex gap-2 flex-wrap">
        @if (session()->has('multicity_options_'. $identifier .'_hotels'))
            @foreach (session('multicity_options_'. $identifier .'_hotels') as $key => $item)
                <div class="inline-flex items-center gap-x-2 font-medium text-[#003663] border rounded-lg p-2">
                    <img class="w-10" src="{{ asset('assets/hotel.svg') }}" alt="Hotel Icon" />
                    <div class="mr-12">Hotels</div>
                    <div class="flex items-center">
                        {{ ($this->editOption)(['type' => 'hotel', 'key' => $key]) }}
                        {{ ($this->deleteOption)(['type' => 'hotel', 'key' => $key]) }}
                    </div>
                </div>
            @endforeach
        @endif

        @if (session()->has('multicity_options_'. $identifier .'_cars'))
            @foreach (session('multicity_options_'. $identifier .'_cars') as $key => $item)
                <div class="inline-flex items-center gap-x-2 font-medium text-[#003663] border rounded-lg p-2">
                    <img class="w-10" src="{{ asset('assets/car.svg') }}" alt="Car Icon" />
                    <div class="mr-12">Cars</div>
                    <div class="flex items-center">
                        {{ ($this->editOption)(['type' => 'car', 'key' => $key]) }}
                        {{ ($this->deleteOption)(['type' => 'car', 'key' => $key]) }}
                    </div>
                </div>
            @endforeach
        @endif

        @if (session()->has('multicity_options_'. $identifier .'_cruises'))
            @foreach (session('multicity_options_'. $identifier .'_cruises') as $key => $item)
                <div class="inline-flex items-center gap-x-2 font-medium text-[#003663] border rounded-lg p-2">
                    <img class="w-10" src="{{ asset('assets/cruise.svg') }}" alt="Cruise Icon" />
                    <div class="mr-12">Cruise</div>
                    <div class="flex items-center">
                        {{ ($this->editOption)(['type' => 'cruise', 'key' => $key]) }}
                        {{ ($this->deleteOption)(['type' => 'cruise', 'key' => $key]) }}
                    </div>
                </div>
            @endforeach
        @endif

        @if (session()->has('multicity_options_'. $identifier .'_activities'))
            @foreach (session('multicity_options_'. $identifier .'_activities') as $key => $item)
                <div class="inline-flex items-center gap-x-2 font-medium text-[#003663] border rounded-lg p-2">
                    <div class="bg-[#EBEFF3] p-3 rounded">
                        <x-filament::icon class="w-5 h-5" icon="heroicon-s-globe-alt" />
                    </div>
                    <div class="mr-12">Activity</div>
                    <div class="flex items-center">
                        {{ ($this->editOption)(['type' => 'activity', 'key' => $key]) }}
                        {{ ($this->deleteOption)(['type' => 'activity', 'key' => $key]) }}
                    </div>
                </div>
            @endforeach
        @endif


        @if (session()->has('multicity_options_'. $identifier .'_transfers'))
            @foreach (session('multicity_options_'. $identifier .'_transfers') as $key => $item)
                <div class="inline-flex items-center gap-x-2 font-medium text-[#003663] border rounded-lg p-2">
                    <div class="bg-[#EBEFF3] p-3 rounded">
                        <x-filament::icon class="w-5 h-5" icon="heroicon-s-globe-alt" />
                    </div>
                    <div class="mr-12">Transfer</div>
                    <div class="flex items-center">
                        {{ ($this->editOption)(['type' => 'transfer', 'key' => $key]) }}
                        {{ ($this->deleteOption)(['type' => 'transfer', 'key' => $key]) }}
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <x-filament-actions::modals />
</div>
