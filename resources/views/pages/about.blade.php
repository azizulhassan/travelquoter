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
                        <a href="{{ route('about') }}"
                            class="hover:text-gray-700  text-[#013663]">{{ __('About Us') }}</a>
                    </div>
                </div>
                <div class="py-10">
                    <h2 class="text-2xl font-bold text-center">{{ __($data['title']) }}</h2>
                    <p class="text-center">{{ __($data['subtitle']) }}</p>
                </div>
            </div>
        </div>
        <div class="max-w-screen-xl mx-auto px-8 md:pt-12">
            <div class="grid lg:grid-cols-2 grid-cols-1 gap-2 items-center lg:my-8">
                <div class="w-full">
                    @if (isset($data->page_content['subtitle']))
                        <p class="text-[#E03F3F] text-sm mb-4">{{ __($data->page_content['subtitle']) }}</p>
                    @endif
                    @if (isset($data->page_content['title']))
                        <p class="text[#101F31] lg:text-lg font-bold mb-4">{{ __($data->page_content['title']) }}</p>
                    @endif
                    @if (isset($data->page_content['description']))
                        <p class="text-[#6F7787] font-pop mr-4">
                            {{ __($data->page_content['description']) }}
                        </p>
                    @endif
                </div>
                <div class="mt-8 md:mt-0">
                    @if (isset($data->page_content['thumbnail']))
                        <div>
                            <button class="relative group w-full rounded-xl border-[10px] border-gray-100 bg-gray-100">
                                <img class="w-full rounded-xl aspect-[4/3] object-cover"
                                    src="{{ asset('uploads/' . $data->page_content['thumbnail']) }}" alt="" />
                                <div onclick="document.querySelector('#how_does_it_work_vid_popup').classList.toggle('hidden')"
                                    class="absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] group-hover:scale-[1.3] transition-all duration-200">
                                    <svg width="51" height="51" viewBox="0 0 51 51" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M25.5 4.25C13.77 4.25 4.25 13.77 4.25 25.5C4.25 37.23 13.77 46.75 25.5 46.75C37.23 46.75 46.75 37.23 46.75 25.5C46.75 13.77 37.23 4.25 25.5 4.25ZM31.1525 29.1762L28.4325 30.7488L25.7125 32.3213C22.2063 34.34 19.3375 32.6825 19.3375 28.645V25.5V22.355C19.3375 18.2963 22.2063 16.66 25.7125 18.6788L28.4325 20.2512L31.1525 21.8238C34.6588 23.8425 34.6588 27.1575 31.1525 29.1762Z"
                                            fill="white" />
                                    </svg>
                                </div>
                            </button>
                        </div>

                        <div id="how_does_it_work_vid_popup" class="fixed w-screen h-screen top-0 right-0 z-50 hidden">
                            <div onclick="document.querySelector('#how_does_it_work_vid_popup').classList.toggle('hidden')"
                                class="bg-gray-900/80 absolute w-full h-full hover:bg-red-800/80 transition-all duration-200">
                            </div>
                            <iframe
                                class="w-[400px] mx-auto mt-20 sm:w-[600px] rounded-xl relative shadow-xl aspect-[16/9] z-90"
                                src="{{ $data->page_content['video'] }}" title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="max-w-screen-xl mx-auto px-8 my-20">
            <div class="text-center">
                @if (isset($data->page_content['why_us_section']['subtitle']))
                    <div class="text-red-600">{{ __($data->page_content['why_us_section']['subtitle']) }}</div>
                @endif
                @if (isset($data->page_content['why_us_section']['title']))
                    <h2 class="text-3xl font-bold font-roman">{{ __($data->page_content['why_us_section']['title']) }}</h2>
                @endif
            </div>
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
