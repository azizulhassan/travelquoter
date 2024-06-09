<div class="max-w-screen-xl mx-auto px-6 sm:px-8">
    <h2 class="font-roman text-lg sm:text-xl md:text-2xl font-bold mt-8 mb-4">{{ __('Blogs') }}</h2>

    @if (count($featured_articles))
        <section wire:ignore class="mx-auto w-full max-w-container">
            <div class="featured-blog-slider splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($featured_articles as $item)
                            <li class="splide__slide" data-splide-interval="3000">
                                <div class="w-full font-medium text-gray-800">
                                    <div class="w-full bg-center bg-cover rounded-xl h-[350px] lg:bg-lg md:bg-md sm:bg-sm"
                                        style="background-image: url('{{ asset('/uploads/' . $item->thumbnail) }}'); border: 1px solid #E2E4E7;">
                                        <div
                                            class="bg-gradient-to-r from-gray-900/90 to-gray-900/40 h-full rounded-xl p-10 lg:p-12">
                                            <div class="w-[90%] space-y-2">

                                                <div class="text-[#ffff] text-sm">
                                                    @if ($item->written_by)
                                                        <span>By {{ $item->written_by }} |</span>
                                                    @endif
                                                    <span>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</span>
                                                </div>

                                                <div class="font-bold text-xl md:text-2xl text-[#ffff]">
                                                    {{ $item->title }}</div>
                                                <div class="text-gray-50 pb-4">{{ $item->short_description }}</div>
                                                <div>
                                                    <x-filament::button color="gray" size="lg" tag="a"
                                                        href="{{ route('blogs.single', ['locale' => app()->getLocale(), 'slug' => $item->slug . '-' . $item->id]) }}">{{ __('Read Article') }}</x-filament::button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="splide__arrows splide__arrows--ltr hidden">
                    <button class="splide__arrow splide__arrow--prev bg-white" type="button"
                        aria-label="Previous slide" aria-controls="splide01-track">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd"
                                d="M16.28 11.47a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 01-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 011.06-1.06l7.5 7.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button class="splide__arrow splide__arrow--next bg-white" type="button" aria-label="Next slide"
                        aria-controls="splide01-track">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd"
                                d="M16.28 11.47a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 01-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 011.06-1.06l7.5 7.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>
    @endif

    <section>
        <div class="pt-12">
            <div class="flex items-center gap-x-2 mb-3">
                <x-filament::input.wrapper class="w-full">
                    <x-filament::input type="text" wire:model.live="search" placeholder="Search" />
                </x-filament::input.wrapper>
                
                @if ($category)
                <x-filament::button size="lg" color="danger" wire:click="refresh">
                    clear
                </x-filament::button>
                @endif
            </div>
            <ul class="flex overflow-x-scroll whitespace-nowrap gap-x-4 py-2 px-[1px]">
                @foreach ($categories as $cat)
                    <li>
                        <label class="relative block ring-1 ring-gray-950/10 px-3 py-2 font-medium bg-white rounded-lg transition-all duraiton-200 @if (in_array($cat->id, $category)) ring-primary-600 text-primary-600 @else hover:ring-primary-600 focus:ring-primary-600 hover:text-primary-600 focus:text-primary-600 @endif">
                            <input style="visibility: hidden;" class="absolute"  wire:model.live="category" type="checkbox" value="{{ $cat->id }}" />    
                            {{ $cat->name }}
                        </label>
                    </li>
                @endforeach
            </ul>
            <div class="grid grid-cols-12 gap-4 mt-4">
                @foreach ($data as $item)
                    <div class="col-span-6 sm:col-span-4 md:col-span-3">
                        <div class="w-full border rounded-lg shadow">
                            <div class="relative">
                                <img class="rounded-tl-lg rounded-tr-lg aspect-[16/9] w-full bg-gray-50"
                                    src="{{ asset('/uploads/' . $item->thumbnail) }}"
                                    alt="{{ $item->title }}" />
                            </div>
                            <div class="p-3">
                                <a href="{{ route('blogs.single', ['slug' => $item->slug . '-' . $item->id]) }}"
                                    class="mb-3 font-medium text-sm line-clamp-1 hover:underline">{{ __($item->title) }}</a>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-x-1">
                                        <img src="{{ asset('img/icons/calender.svg') }}" alt="calender icon" />
                                        <span
                                            class="text-xs line-clamp-1">{{ __(date_format($item->created_at, 'd M Y')) }}</span>
                                    </div>
                                    <div class="flex items-center gap-x-1">
                                        <img src="{{ asset('img/icons/person.svg') }}" alt="person icon">
                                        <span class="text-xs line-clamp-1">{{ __($item->written_by) }}</span>
                                    </div>
                                </div>
                                <p class="text-sm mt-3 line-clamp-2">{{ __($item->short_description) }}</p>
                                @if ($item->newsCategories)
                                    <div class="mt-3">
                                        @foreach ($item->newsCategories as $category)
                                            <span
                                                class="text-xs px-3 py-1 rounded-full bg-gray-200">{{ __($category->name) }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </section>


    @if (count($trending) > 0)
        <section wire:ignore>
            <div class="max-w-screen-xl mx-auto py-12">
                <div class="mb-6">
                    <h2 class="font-roman text-lg sm:text-xl md:text-2xl font-bold">
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
</div>
