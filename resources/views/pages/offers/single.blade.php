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
    <main>
        <section class="max-w-screen-xl mx-auto px-6 py-2">
            <ul class="flex line-clamp-1 gap-x-2">
                <li><a href="{{ route('home') }}" class="hover:text-gray-700 ">{{ __('Home') }}</a>
                </li>
                <li><span>&gt;</span></li>
                <li><a href="{{ route('offers') }}" wire:navigate.hover
                        class="hover:text-gray-700">{{ __('Offers') }}</a></li>
                <li><span>&gt;</span></li>
                <li><span class="text-[#013663]">{{ __($offer->title) }}</span></li>
            </ul>
        </section>

        <section>
            <div class="max-w-screen-xl mx-auto px-6 py-8">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 space-y-2">
                        <div class="flex flex-wrap gap-2 items-end">
                            <h2 class="text-2xl font-semibold text-slate-900">{{ __($offer->title) }}</h2>
                            <div class="flex gap-2">{{ __('Offer Expires In') }}: <span
                                    class="text-primary-600 font-medium">
                                    {{ \Carbon\Carbon::parse($offer->valid_till)->diffInDays($offer->valid_from) }}
                                    {{ __('days') }}</span>
                            </div>
                        </div>
                        <h2 class="pt-1">{{ __('By') }}: {{ __($offer->agent->name) }}</h2>
                    </div>
                    <div class="col-span-12 md:col-span-7 lg:col-span-8">
                        <div>
                            <img class="w-full rounded-lg border shadow" src="{{ asset('/uploads/' . $offer->thumbnail) }}"
                                alt="{{ __($offer->title) }}" />
                        </div>
                        <div class="mt-6">
                            <div class="prose max-w-full">{!! __($offer->description) !!}</div>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-5 lg:col-span-4">
                        <div class="space-y-4 sticky top-1">
                            <x-filament::section>
                                <ul class="space-y-3 border-b pb-4">
                                    <li class="flex items-center gap-x-1">
                                        <x-filament::icon class="w-6 h-6 text-primary-600" icon="heroicon-o-map" />
                                        <span
                                            class="text-gray-700 font-medium">{{ __($offer->extra_field['destination'] ?? 'N/A') }}</span>
                                    </li>
                                    <li class="flex items-center gap-x-1">
                                        <x-filament::icon class="w-6 h-6 text-primary-600" icon="heroicon-o-user" />
                                        <span class="text-gray-700 font-medium">{{ __($offer->person - 1) }} ~
                                            {{ __($offer->person) }} {{ __('Person') }}</span>
                                    </li>
                                    <li class="flex items-center gap-x-1">
                                        <x-filament::icon class="w-6 h-6 text-primary-600"
                                            icon="heroicon-o-calendar-days" />
                                        <span
                                            class="text-gray-700 font-medium">{{ date_format($offer->valid_from, 'd M Y') }}
                                            -
                                            {{ date_format($offer->valid_till, 'd M Y') }}</span>
                                    </li>
                                </ul>
                                <div class="flex justify-between items-end py-4 border-b">
                                    <div class="flex flex-col">
                                        <div class="text-xs">$@money($offer->previous_price)</div>
                                        <div class="text-lg font-bold text-red-600">
                                            $@money($offer->current_price)
                                            <span class="text-xs font-medium">/ {{ __('Person') }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <x-filament::button color="success" icon="heroicon-o-hand-thumb-up"
                                            outlined>{{ \App\Models\OfferLike::where('offer_id', $offer->id)->count() }}
                                            {{ __('Likes') }}</x-filament::button>
                                    </div>
                                </div>
                                <div class="flex flex-wrap justify-between items-center mt-4">
                                    <x-filament::button tag="a" wire:navigate.hover
                                        href="{{ route('offers.request', [
                                            'slug' => Str::slug($offer->title) . '-' . $offer->id,
                                        ]) }}">{{ __('Send Inquiry') }}</x-filament::button>
                                    <x-filament::button color="gray"
                                        icon="heroicon-o-share">{{ __('Share') }}</x-filament::button>
                                </div>
                            </x-filament::section>
                            <x-filament::section>
                                <x-slot name="heading">
                                    {{ __('Subscribe') }}
                                </x-slot>
                                <div class="space-y-4">
                                    @foreach ($agencies as $key => $item)
                                        <livewire:cards.subscriber-card :item="$item" :key="$key" />
                                    @endforeach
                                </div>
                            </x-filament::section>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mb-16">
            <div class="max-w-screen-xl mx-auto px-6 py-8">
                <h3 class="text-[#101F31] mb-4 font-bold lg:text-2xl text-start">{{ __('Other Offers by') }}
                    “{{ __(isset($offer->agent->agency->agency_name) ? $offer->agent->agency->agency_name : $offer->agent->name) }}”
                </h3>

                <ul class="grid grid-cols-12 gap-4 mt-4">
                    @foreach ($offers as $key => $item)
                        <li class="col-span-6 md:col-span-4 lg:col-span-3">
                            <livewire:cards.offer-card :key="$key" :item="$item" />
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    </main>
@stop
