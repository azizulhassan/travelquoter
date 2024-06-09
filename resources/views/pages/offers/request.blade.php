@extends('layouts.page')
@section('seo')
    <title>{{ __($offer->title) }}</title>
    <meta name="description" content="{{ __($offer->title) }}">
    <meta name="author" content="{{ __(env('APP_NAME')) }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:title" content="{{ __($offer->title) }}">
    <meta property="og:description" content="{{ __($offer->title) }}">
    <meta property="og:image" content="{{ asset('/uploads/' . $offer->thumbnail) }}">
    <meta property="twitter:card" content="{{ asset('/uploads/' . $offer->thumbnail) }}">
    <meta property="twitter:url" content="{{ url()->full() }}">
    <meta property="twitter:title" content=" {{ __($offer->title) }}">
    <meta property="twitter:description" content="{{ __($offer->title) }}">
    <meta property="twitter:image" content="{{ asset('/uploads/' . $offer->thumbnail) }}">
@stop
@section('content')
    <main class="max-w-screen-lg mx-auto px-6 md:px-8 pb-20">
        <section class="w-full">
            <div class="items-center text-[#6F7787] text-sm flex-wrap lg:gap-4 my-5">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-gray-700 ">{{ __('Home') }}</a>
                    <span class="mx-2">&gt;</span>
                    <a href="{{ route('offers') }}" wire:navigate.hover
                        class="hover:text-gray-700">{{ __('Offers') }}</a>
                    <span class="mx-2">&gt;</span>
                    <a wire:navigate.hover
                        href="{{ route('offers.single', ['slug' => Str::slug($offer->slug) . '-' . $offer->id]) }}"
                        class="hover:text-gray-700  text-[#013663]">{{ __($offer->title) }}</a>
                    <span class="mx-2">&gt;</span>
                    <span class="hover:text-gray-700 text-gray-500">{{ __('Request') }}</span>
                </div>
            </div>
        </section>

        <section class="flex justify-between flex-col md:flex-row gap-y-2 md:gap-x-2 mt-12 mb-8">
            <div>
                <h2 class="text-2xl font-bold">
                    {{ __('FILL CONTACT') }} <span class="text-red-600">{{ __('INFORMATION') }}</span>
                </h2>
                <div>{{ __('Contact me by') }}</div>
            </div>
            <div>

            </div>
        </section>
        
        <section>
            <livewire:offers.request-form :offer="$offer" />
        </section>
    </main>
@stop
