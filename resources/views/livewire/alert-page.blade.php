<div>
    <section class="bg-gray-50 pb-6">
        <div class="max-w-screen-xl mx-auto px-6 py-2">
            <div class="flex items-center gap-x-2">
                <a href="{{ route('home', app()->getLocale()) }}" class="hover:text-primary-700  text-[#013663]">{{ __('Home') }}</a>
                <x-filament::icon class="w-3 h-3" icon="heroicon-o-chevron-right" />
                <span class="text-[#013663] line-clamp-1">{{ __('Travel Alerts') }}</span>
            </div>
        </div>
        <div class="max-w-screen-md mx-auto px-6 text-center py-4">
            <h1 class="text-primary-600 text-lg mb-4 sm:text-xl md:text-2xl font-bold">{{ __('Travel Alerts') }}</h1>
            <div class="flex items-center gap-x-1">
                <x-filament::input.wrapper class="w-full" prefix-icon="heroicon-s-magnifying-glass">
                    <x-filament::input type="text" wire:model.live="search" placeholder="{{ __('Search...') }}" />
                </x-filament::input.wrapper>
                {{-- <x-filament::button size="lg">
                    <x-filament::icon class="w-4 h-4" icon="heroicon-o-magnifying-glass" />
                </x-filament::button> --}}
            </div>
        </div>
    </section>

    <section>
        <div class="max-w-screen-xl mx-auto px-6 py-12">
            <div class="grid grid-cols-12 gap-y-6 md:gap-4">
                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <div class="sticky top-2">
                        <div id="alerts-types" class="rounded-xl ring-1 ring-gray-950/10 p-6 bg-white space-y-4">
                            @if ($type == 'all-alerts')
                                <x-filament::button wire:click="swapAlertType('all-alerts')" class="w-full"
                                    color="primary" icon="heroicon-s-squares-2x2">All
                                    alerts</x-filament::button>
                            @else
                                <x-filament::button wire:click="swapAlertType('all-alerts')" class="w-full"
                                    color="gray" icon="heroicon-s-squares-2x2">All
                                    alerts</x-filament::button>
                            @endif

                            @if ($type == 'flights')
                                <x-filament::button wire:click="swapAlertType('flights')" class="w-full" color="primary"
                                    icon="heroicon-s-paper-airplane">Flights</x-filament::button>
                            @else
                                <x-filament::button wire:click="swapAlertType('flights')" class="w-full" color="gray"
                                    icon="heroicon-s-paper-airplane">Flights</x-filament::button>
                            @endif

                            @if ($type == 'hotels')
                                <x-filament::button wire:click="swapAlertType('hotels')" class="w-full" color="primary"
                                    icon="heroicon-s-building-office">Hotels</x-filament::button>
                            @else
                                <x-filament::button wire:click="swapAlertType('hotels')" class="w-full" color="gray"
                                    icon="heroicon-s-building-office">Hotels</x-filament::button>
                            @endif

                            @if ($type == 'cars')
                                <x-filament::button wire:click="swapAlertType('cars')" class="w-full" color="primary"
                                    icon="heroicon-s-truck">Cars</x-filament::button>
                            @else
                                <x-filament::button wire:click="swapAlertType('cars')" class="w-full" color="gray"
                                    icon="heroicon-s-truck">Cars</x-filament::button>
                            @endif

                            @if ($type == 'cruises')
                                <x-filament::button wire:click="swapAlertType('cruises')" class="w-full" color="primary"
                                    icon="heroicon-s-map-pin">Cruises</x-filament::button>
                            @else
                                <x-filament::button wire:click="swapAlertType('cruises')" class="w-full" color="gray"
                                    icon="heroicon-s-map-pin">Cruises</x-filament::button>
                            @endif

                            @if ($type == 'visa')
                                <x-filament::button wire:click="swapAlertType('visa')" class="w-full" color="primary"
                                    icon="heroicon-s-identification">Visa</x-filament::button>
                            @else
                                <x-filament::button wire:click="swapAlertType('visa')" class="w-full" color="gray"
                                    icon="heroicon-s-identification">Visa</x-filament::button>
                            @endif

                            @if ($type == 'insurance')
                                <x-filament::button wire:click="swapAlertType('insurance')" class="w-full"
                                    color="primary" icon="heroicon-s-identification">Insurance</x-filament::button>
                            @else
                                <x-filament::button wire:click="swapAlertType('insurance')" class="w-full"
                                    color="gray" icon="heroicon-s-identification">Insurance</x-filament::button>
                            @endif
                        </div>
                        @if (Auth::guard('client')->check())
                            @php
                                $clients = \App\Models\SubscribeAgent::where('client_id', Auth::guard('client')->user()->id)->get();
                            @endphp
                            <div class="mt-6">
                                <x-filament::section>
                                    <x-slot name="heading">
                                        {{ __('Subscribed') }}
                                    </x-slot>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($clients as $key => $item)
                                            <x-filament::badge key="subscribed-agency-{{ $key }}">@
                                                {{ __($item->agent->agency->agency_name) }}</x-filament::badge>
                                        @endforeach
                                    </div>
                                </x-filament::section>
                            </div>
                        @endif
                        <div class="hidden md:block lg:hidden">
                            <div class="mt-6">
                                <x-filament::section>
                                    <x-slot name="heading">
                                        {{ __('Subscribe') }}
                                    </x-slot>

                                    <div class="space-y-6">
                                        @foreach ($agencies as $key => $agency)
                                            <livewire:cards.subscriber-card
                                                key="sm-subscribe-agency-{{ $key }}" :item="$agency" />
                                        @endforeach
                                    </div>

                                    <div class="pt-6 w-full text-center">
                                        <x-filament::link
                                            href="{{ route('agency-list', app()->getLocale()) }}">{{ __('See All') }}</x-filament::link>
                                    </div>
                                </x-filament::section>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-8 lg:col-span-6 space-y-6 md:space-y-4">
                    @if (count($stories) > 0)
                        @foreach ($stories as $key => $story)
                            <livewire:cards.story-card :story="$story" key="story-card-{{ $key }}" />
                        @endforeach
                    @else
                        <x-filament::section>
                            <div class="text-center p-8">
                                <h1 class="font-extrabold text-4xl text-primary-600">{{ __('Oops!') }}</h1>
                                <p class="font-medium text-lg text-gray-800 my-3">
                                    {{ __('Looks like we don\'t have any alerts for you.') }}</p>
                                <p class="font-medium text-lg text-gray-800 my-3">{{ __('') }}</p>
                                <div>
                                    <x-filament::button
                                        wire:click="swapAlertType('all-alerts')">{{ __('View Other Alerts') }}</x-filament::button>
                                </div>
                            </div>
                        </x-filament::section>
                    @endif
                </div>
                <div class="col-span-12 md:hidden lg:block md:col-span-4 lg:col-span-3">
                    <div class="sticky top-2">
                        <x-filament::section>
                            <x-slot name="heading">
                                {{ __('Subscribe') }}
                            </x-slot>

                            <div class="space-y-6">
                                @foreach ($agencies as $key => $agency)
                                    <livewire:cards.subscriber-card key="lg-subscribe-agency-{{ $key }}"
                                        :item="$agency" />
                                @endforeach
                            </div>

                            <div class="pt-6 w-full text-center">
                                <x-filament::link
                                    href="{{ route('agency-list', app()->getLocale()) }}">{{ __('See All') }}</x-filament::link>
                            </div>
                        </x-filament::section>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
