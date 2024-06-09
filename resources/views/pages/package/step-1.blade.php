@extends('layouts.page')
@section('seo')
    <title>{{ __($data->meta_data['meta_title']) }}</title>
    <meta name="description" content="{{ __($data->meta_data['meta_description']) }}" />
    <meta name="author" content="{{ __(env('APP_NAME')) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ __(route('home')) }}" />
    <meta property="og:title" content="{{ __($data->meta_data['meta_title']) }}" />
    <meta property="og:description" content="{{ __($data->meta_data['meta_description']) }}" />
    <meta property="og:image" content="{{ asset('/uploads/' . $data->meta_data['meta_thumbnail']) }}" />
    <meta property="twitter:card" content="{{ asset('/uploads/' . $data->meta_data['meta_thumbnail']) }}" />
    <meta property="twitter:url" content="{{ route('home') }}" />
    <meta property="twitter:title" content=" {{ __($data->meta_data['meta_title']) }}" />
    <meta property="twitter:description" content="{{ __($data->meta_data['meta_description']) }}" />
    <meta property="twitter:image" content="{{ asset('/uploads/' . $data->meta_data['meta_thumbnail']) }}" />
@stop
@section('extended-navbar')
    <nav aria-label="{{ __('Extended Navbar') }}" class="bg-[#06345A] w-full border-t-2 border-[#094272] py-3">
        <ul class="max-w-screen-xl mx-auto px-3 md:px-8 flex flex-wrap gap-3 md:gap-x-8 md:gap-y-2">
            <li>
                <a href="{{ route('flight.step-1') }}"
                    class="inline-flex items-center gap-x-1 text-white border border-transparent hover:border-white rounded-full hover:bg-[#1F486A] rounded-full px-4 py-2 text-sm md:text-basic {{ Route::currentRouteName() == 'flight.step-1' || Route::currentRouteName() == 'flight.step-2' || Route::currentRouteName() == 'flight.step-3' ? 'bg-[#1F486A] border border-white' : '' }}">
                    <img src="{{ asset('assets/icons/flight-white-icon.svg') }}" alt="{{ __('Flights') }}" />
                    <span>{{ __('Flights') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('hotel.step-1') }}"
                    class="inline-flex items-center gap-x-1 text-white border border-transparent hover:border-white rounded-full hover:bg-[#1F486A] rounded-full px-4 py-2 text-sm md:text-basic {{ Route::currentRouteName() == 'hotel.step-1' || Route::currentRouteName() == 'hotel.step-2' || Route::currentRouteName() == 'hotel.step-3' ? 'bg-[#1F486A] border border-white' : '' }}">
                    <img src="{{ asset('assets/icons/hotel-white-icon.svg') }}" alt="{{ __('Hotel') }}" />
                    <span>{{ __('Hotel') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('car.step-1') }}"
                    class="inline-flex items-center gap-x-1 text-white border border-transparent hover:border-white rounded-full hover:bg-[#1F486A] rounded-full px-4 py-2 text-sm md:text-basic {{ Route::currentRouteName() == 'car.step-1' || Route::currentRouteName() == 'car.step-2' || Route::currentRouteName() == 'car.step-3' ? 'bg-[#1F486A] border border-white' : '' }}">
                    <img src="{{ asset('assets/icons/car-hire-white-icon.svg') }}" alt="{{ __('Car Hire') }}" />
                    <span>{{ __('Car Hire') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('cruise.step-1') }}"
                    class="inline-flex items-center gap-x-1 text-white border border-transparent hover:border-white rounded-full hover:bg-[#1F486A] rounded-full px-4 py-2 text-sm md:text-basic {{ Route::currentRouteName() == 'cruise.step-1' || Route::currentRouteName() == 'cruise.step-2' || Route::currentRouteName() == 'cruise.step-3' ? 'bg-[#1F486A] border border-white' : '' }}">
                    <img src="{{ asset('assets/icons/cruise-white-icon.svg') }}" alt="{{ __('Cruise') }}" />
                    <span>{{ __('Cruises') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('insurance.step-1') }}"
                    class="inline-flex items-center gap-x-1 text-white border border-transparent hover:border-white rounded-full hover:bg-[#1F486A] rounded-full px-4 py-2 text-sm md:text-basic {{ Route::currentRouteName() == 'insurance.step-1' || Route::currentRouteName() == 'insurance.step-2' || Route::currentRouteName() == 'insurance.step-3' ? 'bg-[#1F486A] border border-white' : '' }}">
                    <img src="{{ asset('assets/icons/insurance-white-icon.svg') }}" alt="{{ __('Insurance') }}" />
                    <span>{{ __('Insurance') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('visa.step-1') }}"
                    class="inline-flex items-center gap-x-1 text-white border border-transparent hover:border-white rounded-full hover:bg-[#1F486A] rounded-full px-4 py-2 text-sm md:text-basic {{ Route::currentRouteName() == 'visa.step-1' || Route::currentRouteName() == 'visa.step-2' || Route::currentRouteName() == 'visa.step-3' ? 'bg-[#1F486A] border border-white' : '' }}">
                    <img src="{{ asset('assets/icons/visa-white-icon.svg') }}" alt="{{ __('Visa') }}" />
                    <span>{{ __('Visa') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('offers') }}"
                    class="inline-flex items-center gap-x-1 text-white border border-transparent hover:border-white rounded-full hover:bg-[#1F486A] rounded-full px-4 py-2 text-sm md:text-basic">
                    <img src="{{ asset('assets/icons/package-white-icon.svg') }}" alt="{{ __('Package') }}" />
                    <span>{{ __('Packages') }}</span>
                </a>
            </li>
        </ul>
    </nav>
@stop
@section('content')
    <main>
        <section>
            <div class="max-w-screen-xl px-3 md:px-8 mx-auto mt-12">
                <h1 class="text-2xl font-bold">{{ __('Get Quote') }}</h1>
                <ul class="flex items-center mt-3">
                    <li class="w-8 h-8 flex items-center justify-center rounded-full bg-red-600 text-white">
                        {{ __('1') }}
                    </li>
                    <li>
                        <div class="w-12 h-[2px] bg-[#E2E4E7]"></div>
                    </li>
                    <li class="w-8 h-8 flex items-center justify-center rounded-full bg-[#E2E4E7] text-white">
                        {{ __('2') }}
                    </li>
                    <li>
                        <div class="w-12 h-[2px] bg-[#E2E4E7]"></div>
                    </li>
                    <li class="w-8 h-8 flex items-center justify-center rounded-full bg-[#E2E4E7] text-white">
                        {{ __('3') }}
                    </li>
                </ul>
            </div>
        </section>

        <section>
            <div class="max-w-screen-xl px-3 md:px-8 mx-auto mt-12">
                <h1 class="font-bold text-2xl">
                    {{ __('FIND YOUR') }} <span class="text-red-600">{{ __('HOTEL') }}</span>
                </h1>
                <div>{{ __('Search hotels and homes!') }}</div>
            </div>

            <div class="max-w-screen-xl px-3 md:px-8 mx-auto mt-10 mb-20">
                <livewire:package.step1-form />
            </div>
        </section>
    </main>
@stop
