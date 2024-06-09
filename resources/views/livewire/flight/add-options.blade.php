<div>
    <div>
        @if (
            (session()->has($flight_type . '_options_hotels_' . $id) &&
                count(session($flight_type . '_options_hotels_' . $id)) > 0) ||
                (session()->has($flight_type . '_options_cars_' . $id) &&
                    count(session($flight_type . '_options_cars_' . $id)) > 0) ||
                (session()->has($flight_type . '_options_cruises_' . $id) &&
                    count(session($flight_type . '_options_cruises_' . $id)) > 0) ||
                (session()->has($flight_type . '_options_activities_' . $id) &&
                    count(session($flight_type . '_options_activities_' . $id)) > 0) ||
                (session()->has($flight_type . '_options_transfers_' . $id) &&
                    count(session($flight_type . '_options_transfers_' . $id)) > 0))
            <div class="text-basic font-bold text-gray-800 mb-2">Options</div>

            <div class="flex flex-wrap gap-3 mb-4">
                @if (session()->has($flight_type.'_options_hotels_'.$id))
                    @foreach (session($flight_type.'_options_hotels_'.$id) as $key => $item)
                        <div
                            class="inline-flex text-sm items-center gap-x-2 font-medium text-primary-600 bg-white border rounded-lg p-2">
                            <img class="w-9" src="{{ asset('assets/hotel.svg') }}" alt="Hotel Icon" />
                            <div class="mr-12">Hotels</div>
                            <div class="flex items-center gap-2">
                                {{ ($this->editOption)(['type' => 'hotel', 'key' => $key]) }}
                                {{ ($this->deleteOption)(['type' => 'hotel', 'key' => $key]) }}
                            </div>
                        </div>
                    @endforeach
                @endif

                @if (session()->has($flight_type.'_options_cars_'.$id))
                    @foreach (session('oneway_options_cars_'.$id) as $key => $item)
                        <div class="inline-flex text-sm items-center gap-x-2 font-medium text-primary-600 bg-white border rounded-lg p-2">
                            <img class="w-9" src="{{ asset('assets/car.svg') }}" alt="Car Icon" />
                            <div class="mr-12">Cars</div>
                            <div class="flex items-center gap-2">
                                {{ ($this->editOption)(['type' => 'car', 'key' => $key]) }}
                                {{ ($this->deleteOption)(['type' => 'car', 'key' => $key]) }}
                            </div>
                        </div>
                    @endforeach
                @endif

                @if (session()->has($flight_type.'_options_cruises_'.$id))
                    @foreach (session('oneway_options_cruises_'.$id) as $key => $item)
                        <div class="inline-flex text-sm items-center gap-x-2 font-medium text-primary-600 bg-white border rounded-lg p-2">
                            <img class="w-9" src="{{ asset('assets/cruise.svg') }}" alt="Cruise Icon" />
                            <div class="mr-12">Cruise</div>
                            <div class="flex items-center gap-2">
                                {{ ($this->editOption)(['type' => 'cruise', 'key' => $key]) }}
                                {{ ($this->deleteOption)(['type' => 'cruise', 'key' => $key]) }}
                            </div>
                        </div>
                    @endforeach
                @endif

                @if (session()->has($flight_type.'_options_activities_'.$id))
                    @foreach (session('oneway_options_activities_'.$id) as $key => $item)
                        <div class="inline-flex text-sm items-center gap-x-2 font-medium text-primary-600 bg-white border rounded-lg p-2">
                            <div class="bg-[#EBEFF3] p-3 rounded">
                                <x-filament::icon class="w-5 h-5" icon="heroicon-s-globe-alt" />
                            </div>
                            <div class="mr-12">Activity</div>
                            <div class="flex items-center gap-2">
                                {{ ($this->editOption)(['type' => 'activity', 'key' => $key]) }}
                                {{ ($this->deleteOption)(['type' => 'activity', 'key' => $key]) }}
                            </div>
                        </div>
                    @endforeach
                @endif

                @if (session()->has($flight_type.'_options_transfers_'.$id))
                    @foreach (session('oneway_options_transfers_'.$id) as $key => $item)
                        <div class="inline-flex text-sm items-center gap-x-2 font-medium text-primary-600 bg-white border rounded-lg p-2">
                            <div class="bg-[#EBEFF3] p-3 rounded">
                                <x-filament::icon class="w-5 h-5" icon="heroicon-s-globe-alt" />
                            </div>
                            <div class="mr-12">Transfer</div>
                            <div class="flex items-center gap-2">
                                {{ ($this->editOption)(['type' => 'transfer', 'key' => $key]) }}
                                {{ ($this->deleteOption)(['type' => 'transfer', 'key' => $key]) }}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        @endif

        <x-filament::button size="xs" @click="$dispatch('open-modal', { id: 'add-options-modal' })"
            icon="heroicon-o-plus" outlined>Add Options</x-filament::button>
    </div>

    <x-filament::modal id="add-options-modal">
        <x-slot name="heading">
            Add options
        </x-slot>
        <div class="space-y-4">
            @foreach ($types as $key => $value)
                <label
                    class="flex justify-between items-center p-2 rounded-lg ring-1 ring-gray-950/10 font-medium hover:ring-primary-600 hover:bg-gray-100 text-sm @if ($key == $option_type) text-primary-600 ring-primary-600 bg-gray-100 @else text-gray-600 @endif">
                    <div>{{ $value }}</div>
                    <input class="text-primary-600 focus:outline-0 focus:ring-0 focus:border-0"
                        wire:model.live="option_type" type="radio" value="{{ $key }}" />
                </label>
            @endforeach
        </div>
        <x-slot name="footerActions">
            <x-filament::button wire:click="next" class="w-full">Next</x-filament::button>
        </x-slot>
    </x-filament::modal>

    <x-filament-actions::modals />
</div>
