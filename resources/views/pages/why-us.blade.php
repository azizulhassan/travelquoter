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
@section('content')
    <main>
        <div class="bg-[#f4faf9] w-full bg-repeat">
            <div class="max-w-screen-xl flex-wrap items-center justify-between mx-auto sm:px-10 px-4 pt-3">
                <div class="bread-crumb   items-center text-gray-500 text-sm flex-wrap lg:gap-4 ">
                    <div class="flex items-center gap-x-2">
                        <a href="{{ route('home') }}"
                            class="hover:text-gray-700">{{ __('Home') }}</a>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                        <a href="{{ route('why-us') }}"
                            class="hover:text-gray-700  text-[#013663]">{{ __('Why Us') }}</a>
                    </div>
                </div>
                <div class="py-10">
                    <h2 class="text-2xl font-bold text-center">{{ __('Why Choose Us') }}</h2>
                    <p class="text-center">{{ __($data['subtitle']) }}</p>
                </div>
            </div>
        </div>

        <div class="max-w-screen-xl mx-auto px-8 my-20">
            @if (isset($data->page_content['why_us_section']['content']))
                <div class="grid grid-cols-12 gap-4 mt-8">
                    @foreach ($data->page_content['why_us_section']['content'] as $item)
                        <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                            <div class="rounded-lg border h-full p-4 bg-white">
                                <div class="rounded-lg mb-3">
                                    <img class="w-12 sm:w-16 aspect-[2/2] rounded-lg object-cover"
                                        src="{{ asset('uploads/' . $item['icon']) }}"
                                        alt="{{ __($item['title']) }} {{ __('Icon') }}" />
                                </div>
                                <h3 class="font-bold text-basic mb-1">{{ __($item['title']) }}</h3>
                                <p class="text-sm text-gray-700">
                                    {{ __($item['description']) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
@stop
