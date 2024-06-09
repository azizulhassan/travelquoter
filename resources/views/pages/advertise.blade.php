@extends('layouts.page')
@section('seo')
@stop
@section('content')
<main>
    <div class="bg-[#f4faf9] w-full bg-repeat">
        <div class="max-w-screen-xl flex-wrap items-center justify-between mx-auto sm:px-10 px-4 pt-3">
            <div class="bread-crumb   items-center text-gray-500 text-sm flex-wrap lg:gap-4 ">
                <div class="flex items-center gap-x-2">
                    <a href="{{ route('home') }}" class="hover:text-gray-700">{{ __('Home') }}</a>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-3 h-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                    <a href="{{ route('contact') }}" class="hover:text-gray-700  text-[#013663]">{{ __('Advertise with us') }}</a>
                </div>
            </div>
            <div class="py-10">
                <h2 class="text-2xl font-bold text-center">{{ __($data['title']) }}</h2>
                <p class="text-center">{{ __($data['subtitle']) }}</p>
            </div>
        </div>
    </div>

    <div class="max-w-screen-xl mx-auto sm:px-10 px-4 my-12">
        <div class="border w-full rounded-2xl">
            <div class="grid grid-cols-12 gap-8">
                <div class="col-span-12 md:col-span-6 lg:col-span-8 p-8">
                    <livewire:forms.advertise-with-us-form />
                </div>
                <div class="col-span-12 hidden md:block md:col-span-6 lg:col-span-4">
                    <img class="h-full object-cover md:rounded-r-2xl w-full"
                        src="{{ asset("uploads/contact_us_thumbnail.png") }}" alt="{{ __('Thumbnail') }}" />
                </div>
            </div>
        </div>
    </div>
</main>
@stop