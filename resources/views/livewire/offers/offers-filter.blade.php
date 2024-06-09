<div class="grid grid-cols-12 gap-4 mb-16">
    <div class="col-span-12 md:col-span-4 lg:col-span-3 mb-6">
        <div class="sticky top-0">
            {{ $this->form }}
        </div>
    </div>
    <div class="col-span-12 md:col-span-8 lg:col-span-9">
        <section>
            <div class="mb-8">
                <input wire:model.live="agent" type="search"
                    class="block w-full p-3 text-sm text-gray-900 border border-gray-200 focus:border-[#003663] rounded-lg bg-white" placeholder="{{ __('Search by agent name') }}" />
            </div>

            <div wire:loading.class.remove="hidden" class="hidden grid grid-cols-12 gap-4">
                <div class="col-span-6 sm:col-span-6 lg:col-span-4">
                    <div class="space-y-2 border rounded-lg p-2 bg-white shadow">
                        <div class="skeleton-loader w-full h-36 rounded-lg"></div>
                        <div class="skeleton-loader w-1/3 h-3 rounded-lg"></div>
                        <div class="skeleton-loader w-full h-3 rounded-lg"></div>
                        <div class="skeleton-loader w-full h-3 rounded-lg"></div>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-6 lg:col-span-4">
                    <div class="space-y-2 border rounded-lg p-2 bg-white shadow">
                        <div class="skeleton-loader w-full h-36 rounded-lg"></div>
                        <div class="skeleton-loader w-1/3 h-3 rounded-lg"></div>
                        <div class="skeleton-loader w-full h-3 rounded-lg"></div>
                        <div class="skeleton-loader w-full h-3 rounded-lg"></div>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-6 lg:col-span-4 hidden lg:block">
                    <div class="space-y-2 border rounded-lg p-2 bg-white shadow">
                        <div class="skeleton-loader w-full h-36 rounded-lg"></div>
                        <div class="skeleton-loader w-1/3 h-3 rounded-lg"></div>
                        <div class="skeleton-loader w-full h-3 rounded-lg"></div>
                        <div class="skeleton-loader w-full h-3 rounded-lg"></div>
                    </div>
                </div>
            </div>

            @if (count($offers) > 0)
                <section class="my-8">
                    <div class="max-w-screen-xl mx-auto">
                        <div class="mb-6">
                            <h2 class="font-roman text-2xl font-medium">
                                @if ($offers)
                                    {{ __('Search Result') }}
                                @else
                                    {{ __('Recent Offers') }}
                                @endif
                            </h2>
                        </div>
                        <ul class="grid grid-cols-12 gap-4">
                            @foreach ($offers as $key => $item)
                                <li wire:key="{{ $key }}" class="col-span-6 sm:col-span-6 lg:col-span-4">
                                    @php
                                        $offer_days = 0;
                                        $likes = 0;
                                    @endphp
                                    <div class="w-full border rounded-lg shadow">
                                        <div class="relative">
                                            <img class="rounded-tl-lg rounded-tr-lg" src="{{ asset('/uploads/' . $item->thumbnail) }}"
                                                alt="{{ __($item->title) }}" />
                                            <button wire:click="addLikes"
                                                class="absolute top-2 left-2 text-white transition-all duration-200 hover:text-[#E03F3F]">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                    <path
                                                        d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                                </svg>
                                            </button>
                                            <div class="absolute top-2 right-2 bg-gray-900/80 text-gray-50 rounded-lg px-2 py-1 text-xs">
                                                @if (isset($item->agent->name))
                                                    {{ __('By') }}: {{ __($item->agent->name) }}
                                                @else
                                                    @if (isset($item->user->name))
                                                        {{ __('By') }}: {{ __($item->user->name) }}
                                                    @else
                                                        {{ __('By') }}: {{ __($item->agent->name) }}
                                                    @endif
                                                @endif
                                            </div>
                                            @if ($offer_days)
                                                <div
                                                    class="absolute bottom-2 left-[50%] translate-x-[-50%] text-xs italic bg-gray-900/70 w-[90%] text-gray-50 rounded-lg px-2 py-1 text-center">
                                                    {{ __('Offer Expires in') }}: <strong>{{ __($offer_days) }} {{ __('days') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="p-2">
                                                <a href="{{ route('offers.single', ['slug' => Str::slug($item->item).'-'.$item->id]) }}" class="block font-bold text-sm line-clamp-1">{{ __($item->title) }}</a>
                                                <div class="text-xs text-gray-500 my-1">
                                                    {{ __('Between') }}:
                                                    {{ __(\Carbon\Carbon::parse($item->valid_from)->format('d M')) }} -
                                                    @if ($item->valid_till)
                                                        {{ __(\Carbon\Carbon::parse($item->valid_till)->format('d M')) }}
                                                    @endif
                                                </div>
                                    
                                                <div class="flex items-center text-xs gap-x-1 text-gray-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                        <path fill-rule="evenodd"
                                                            d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span>{{ __($item->extra_field['destination'] ?? "N/A") }}</span>
                                                </div>
                                                <div class="border-t mt-4 pt-4 flex justify-between items-end">
                                                    <div>
                                                        <div class="text-xs text-[#013663] line-through">
                                                            $@money($item->previous_price)
                                                        </div>
                                                        <div class="flex items-center gap-x-1">
                                                            <span class="font-bold text-red-600">$@money($item->current_price)</span><span
                                                                class="text-xs text-[#013663]">/ {{ __('Person') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex text-[#013763] gap-x-1 items-center text-xs mb-[5px]">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                            <path
                                                                d="M7.493 18.75c-.425 0-.82-.236-.975-.632A7.48 7.48 0 016 15.375c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75 2.25 2.25 0 012.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23h-.777zM2.331 10.977a11.969 11.969 0 00-.831 4.398 12 12 0 00.52 3.507c.26.85 1.084 1.368 1.973 1.368H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 01-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227z" />
                                                        </svg>
                                                        <span>{{ $likes }} {{ __('Likes') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>
            @else
                <section class="my-8">
                    <div class="bg-gray-100 rounded-lg border p-3 shadow text-gray-700 text-center">{{ __('Not Found') }}</div>
                </section>
            @endif
        </section>

        <div wire:ignore>
            @if (count($daily_deals) > 0)
                <section>
                    <div class="max-w-screen-xl mx-auto">
                        <div class="mb-6">
                            <h2 class="font-roman text-2xl font-medium">
                                {{ __('Daily Deals') }}
                            </h2>
                        </div>
                        <div class="daily-deals splide">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    @foreach ($daily_deals as $key => $item)
                                        <li class="splide__slide">
                                            <livewire:cards.offer-card :item="$item" :key="$key" />
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

            @if (count($top_offers) > 0)
                <section class="mt-8">
                    <div class="max-w-screen-xl mx-auto">
                        <div class="mb-6">
                            <h2 class="font-roman text-2xl font-medium">
                                {{ __('Top Offers') }}
                            </h2>
                        </div>
                        <div class="top-offers splide">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    @foreach ($top_offers as $key => $item)
                                        <li class="splide__slide">
                                            <livewire:cards.offer-card :item="$item" :key="$key" />
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

            @if (count($recommended_offers) > 0)
                <section class="mt-8">
                    <div class="max-w-screen-xl mx-auto">
                        <div class="mb-6">
                            <h2 class="font-roman text-2xl font-medium">
                                {{ __('Recommended for you') }}
                            </h2>
                        </div>
                        <div class="recommended-offers splide">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    @foreach ($recommended_offers as $key => $item)
                                        <li class="splide__slide">
                                            <livewire:cards.offer-card :item="$item" :key="$key" />
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
    </div>
</div>
