@extends('layouts.page')
@section('seo')
    <title>{{ __($blog->title) }}</title>
    <meta name="description" content="{{ __($blog->short_description) }}" />
    <meta name="author" content="{{ __(env('APP_NAME')) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->full() }}" />
    <meta property="og:title" content="{{ __($blog->title) }}" />
    <meta property="og:description" content="{{ __($blog->short_description) }}" />
    <meta property="og:image" content="{{ asset('/uploads/' . $blog->thumbnail) }}" />
    <meta property="twitter:card" content="{{ asset('/uploads/' . $blog->thumbnail) }}" />
    <meta property="twitter:url" content="{{ url()->full() }}" />
    <meta property="twitter:title" content=" {{ __($blog->title) }}" />
    <meta property="twitter:description" content="{{ __($blog->short_description) }}" />
    <meta property="twitter:image" content="{{ asset('/uploads/' . $blog->thumbnail) }}" />
@stop
@section('content')
    <main>
        <section>
            <div class="max-w-screen-xl mx-auto px-6 py-2">
                <div class="flex items-center gap-x-2">
                    <a href="{{ route('blogs') }}" class="hover:text-gray-700  text-[#013663]">{{ __('Blog') }}</a>
                    <x-filament::icon class="w-3 h-3" icon="heroicon-o-chevron-right" />
                    <span class="text-[#013663] line-clamp-1">{{ __($blog->slug) }}</span>
                </div>
            </div>
        </section>

        <section>
            <div class="max-w-screen-xl mx-auto px-6 mt-4">
                <img class="rounded-xl w-full aspect-[4/2] md:aspect-[6/2] object-cover" src="{{ asset('uploads/' . $blog->thumbnail) }}"
                    alt="{{ __($blog->title) }}" />
                <h1 class="text-3xl my-5 text-[#101F31] font-bold">{{ __($blog->title) }}
                </h1>
                <div class="flex items-center gap-x-3 pb-2">
                    <div class="flex items-center gap-x-1">
                        <img src="{{ asset('img/icons/calender.svg') }}" alt="calender icon" />
                        <span class="text-basic line-clamp-1">{{ __(date_format($blog->created_at, 'd M Y')) }}</span>
                    </div>
                    <div class="flex items-center gap-x-1">
                        <img src="{{ asset('img/icons/person.svg') }}" alt="person icon">
                        <span class="text-basic line-clamp-1">{{ __($blog->written_by) }}</span>
                    </div>
                </div>
                @if ($blog->newsCategories)
                    <div class="mt-3">
                        @foreach ($blog->newsCategories as $category)
                            <span class="text-basic px-3 py-1 rounded-full bg-gray-200">{{ __($category->name) }}</span>
                        @endforeach
                    </div>
                @endif
                <div class="prose max-w-full mt-6">{!! __($blog->description) !!}</div>
            </div>
        </section>

        @if (count($trending) > 0)
            <section>
                <div class="max-w-screen-xl mx-auto px-6 py-12">
                    <div class="mb-6">
                        <h2 class="font-roman text-3xl font-bold">
                            Trending Articles
                        </h2>
                    </div>
                    <div class="trending-blog-slider splide">
                        <div class="splide__track">
                            <ul class="splide__list">
                                @foreach ($trending as $item)
                                    <li class="splide__slide">
                                        <livewire:cards.blog-card :item="$item" />
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="splide__arrows splide__arrows--ltr">
                            <button class="splide__arrow splide__arrow--prev bg-white" type="button"
                                aria-label="Previous slide" aria-controls="splide01-track">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6">
                                    <path fill-rule="evenodd"
                                        d="M16.28 11.47a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 01-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 011.06-1.06l7.5 7.5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button class="splide__arrow splide__arrow--next bg-white" type="button"
                                aria-label="Next slide" aria-controls="splide01-track">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6">
                                    <path fill-rule="evenodd"
                                        d="M16.28 11.47a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 01-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 011.06-1.06l7.5 7.5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </main>
@stop
