@extends('layouts.app')
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
        <section class="relative">
            <img class="w-full h-[600px] object-cover"
                src="{{ asset('/uploads/' . $data->page_content['hero_section']['background']) }}"
                alt="{{ __($data->page_content['hero_section']['title']) }}" />
            <div class="mx-auto max-w-screen-xl px-8">
                <div class="absolute z-40 top-[20%]">
                    <h1 class="font-roman text-3xl sm:text-4xl max-w-md text-white">
                        {{ __($data->page_content['hero_section']['title']) }}
                    </h1>
                    <span class="text-white my-4 block">{{ __($data->page_content['hero_section']['subtitle']) }}</span>
                    <div
                        class="flex flex-wrap w-[95%] sm:w-[550px] md:w-[650px] lg:w-auto gap-3 sm:gap-6 p-3 sm:p-5 rounded-lg bg-white/70">
                        <a href="{{ route('flight.step-1', app()->getLocale()) }}"
                            class="block bg-[#013663] w-16 h-16 sm:w-20 sm:h-20 p-2 rounded-lg flex flex-col items-center justify-center gap-y-2 text-white text-sm">
                            <img class="w-8 h-8 object-contain" src="{{ asset('assets/icons/flight-icon.svg') }}"
                                alt="{{ __('Flight icon') }}" />
                            <span>{{ __('Flights') }}</span>
                        </a>
                        <a href="{{ route('hotel.step-1', app()->getLocale()) }}"
                            class="block bg-white w-16 h-16 sm:w-20 sm:h-20 p-2 rounded-lg flex flex-col items-center justify-center gap-y-2 text-[#013663] text-sm">
                            <img class="w-8 h-8 object-contain" src="{{ asset('assets/icons/hotel-icon.svg') }}"
                                alt="{{ __('Hotel icon') }}" />
                            <span>{{ __('Hotels') }}</span>
                        </a>
                        <a href="{{ route('car.step-1', app()->getLocale()) }}"
                            class="block bg-white w-16 h-16 sm:w-20 sm:h-20 p-2 rounded-lg flex flex-col items-center justify-center gap-y-2 text-[#013663] text-sm">
                            <img class="w-8 h-8 object-contain" src="{{ asset('assets/icons/car-icon.svg') }}"
                                alt="{{ __('Car icon') }}" />
                            <span>{{ __('Cars') }}</span>
                        </a>
                        <a href="{{ route('cruise.step-1', app()->getLocale()) }}"
                            class="block bg-white w-16 h-16 sm:w-20 sm:h-20 p-2 rounded-lg flex flex-col items-center justify-center gap-y-2 text-[#013663] text-sm">
                            <img class="w-8 h-8 object-contain" src="{{ asset('assets/icons/cruise-icon.svg') }}"
                                alt="{{ __('Cruise icon') }}" />
                            <span>{{ __('Cruises') }}</span>
                        </a>
                        <a href="{{ route('insurance.step-1', app()->getLocale()) }}"
                            class="block bg-white w-16 h-16 sm:w-20 sm:h-20 p-2 rounded-lg flex flex-col items-center justify-center gap-y-2 text-[#013663] text-sm">
                            <img class="w-8 h-8 object-contain" src="{{ asset('assets/icons/insurance-icon.svg') }}"
                                alt="{{ __('Insurance icon') }}" />
                            <span>{{ __('Insurance') }}</span>
                        </a>
                        <a href="{{ route('visa.step-1', app()->getLocale()) }}"
                            class="block bg-white w-16 h-16 sm:w-20 sm:h-20 p-2 rounded-lg flex flex-col items-center justify-center gap-y-2 text-[#013663] text-sm">
                            <img class="w-8 h-8 object-contain" src="{{ asset('assets/icons/visa-icon.svg') }}"
                                alt="{{ __('Visa icon') }}" />
                            <span>{{ __('Visa') }}</span>
                        </a>
                        <a href="{{ route('offers', app()->getLocale()) }}"
                            class="block bg-white w-16 h-16 sm:w-20 sm:h-20 p-2 rounded-lg flex flex-col items-center justify-center gap-y-2 text-[#013663] text-sm">
                            <img class="w-8 h-8 object-contain" src="{{ asset('assets/icons/package-icon.svg') }}"
                                alt="{{ __('Package icon') }}" />
                            <span>{{ __('Packages') }}</span>
                        </a>
                        <a href="{{ route('gtrip.step-1', app()->getLocale()) }}"
                            class="block bg-white w-16 h-16 sm:w-20 sm:h-20 p-2 rounded-lg flex flex-col items-center justify-center gap-y-2 text-[#013663] text-sm">
                            <img class="w-8 h-8 object-contain" src="{{ asset('assets/icons/gtrip-icon.svg') }}"
                                alt="{{ __('Gtrip icon') }}" />
                            <span>{{ __('G-Trip') }}</span>
                        </a>
                    </div>
                    <div class="mt-3">
                        <livewire:cards.date-calculator-card />
                    </div>
                </div>
            </div>
        </section>

        @if (count($offers) > 0)
            <section>
                <div class="max-w-screen-xl mx-auto px-8 py-12">
                    <div class="mb-6">
                        <span class="text-sm text-red-600">{{ $data->page_content['offer_section']['subtitle'] }}</span>
                        <h2 class="font-roman text-3xl font-bold">
                            {{ $data->page_content['offer_section']['title'] }}
                        </h2>
                    </div>
                    <div class="offers-section splide">
                        <div class="splide__track">
                            <ul class="splide__list">
                                @foreach ($offers as $key => $item)
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


        @if (isset($data->page_content['app_promotion_section']))
            <section class="bg-[#013663] relative mt-20">
                <div class="max-w-screen-xl mx-auto px-8">
                    <div class="grid grid-cols-12 items-center justify-between gap-y-5 md:gap-x-5 py-12 xl:py-0">
                        <div class="col-span-12 md:col-span-5 lg:col-span-6 text-center md:text-left">
                            <div class="text-gray-50 mb-3">
                                {{ __($data->page_content['app_promotion_section']['subtitle']) }}
                            </div>
                            <div class="font-roman text-3xl text-gray-50 mb-10">
                                {{ __($data->page_content['app_promotion_section']['title']) }}
                            </div>
                            <div class="text-white text-sm">
                                {{ __($data->page_content['app_promotion_section']['description']) }}
                            </div>
                            <div class="flex gap-x-2 mt-10 justify-center md:justify-start">
                                <a href="{{ $data->page_content['app_promotion_section']['apple_appstore_link'] }}">
                                    <svg width="156" height="52" viewBox="0 0 156 52" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect width="156" height="52" rx="8" fill="white" />
                                        <g clip-path="url(#clip0_769_5719)">
                                            <path
                                                d="M35.6937 37.0508L30.203 27.6642C29.8729 27.0552 29.6999 26.3735 29.6999 25.6808C29.6999 24.9882 29.8729 24.3064 30.203 23.6975L31.003 22.3762L35.0203 29.2508H39.8417C40.0539 29.2594 40.2621 29.3116 40.4533 29.4042C40.6445 29.4968 40.8145 29.6279 40.9528 29.7892C41.0911 29.9504 41.1946 30.1385 41.2569 30.3416C41.3192 30.5447 41.339 30.7584 41.315 30.9695C41.307 31.3913 41.1345 31.7932 40.8344 32.0896C40.5342 32.386 40.1302 32.5535 39.7083 32.5562H36.895L38.6403 35.4668C38.6578 35.4668 38.6752 35.4703 38.6913 35.477C38.7075 35.4837 38.7222 35.4935 38.7346 35.5059C38.747 35.5183 38.7568 35.533 38.7635 35.5491C38.7702 35.5653 38.7737 35.5827 38.7737 35.6002C38.9536 36.006 38.9709 36.4655 38.822 36.8837C38.6732 37.302 38.3695 37.6472 37.9737 37.8482C37.7599 37.9524 37.5248 38.0058 37.287 38.0042C36.9602 38.0033 36.6397 37.9143 36.3593 37.7465C36.0788 37.5787 35.8489 37.3384 35.6937 37.0508ZM18.015 37.5842C17.8213 37.4819 17.6517 37.3394 17.5176 37.1662C17.3834 36.993 17.2879 36.7932 17.2372 36.5801C17.1866 36.367 17.1821 36.1455 17.224 35.9305C17.266 35.7155 17.3533 35.512 17.4803 35.3335L17.6137 35.2002C17.7898 34.8901 18.0422 34.6301 18.3469 34.4448C18.6516 34.2595 18.9986 34.1551 19.355 34.1415H22.0323L20.4257 36.9188L20.2923 37.0522C20.1598 37.291 19.9627 37.4877 19.7236 37.6198C19.4845 37.7518 19.2131 37.8139 18.9403 37.7988C18.6192 37.7976 18.3027 37.7228 18.015 37.5802V37.5842ZM16.2737 32.5562C15.8394 32.5225 15.4336 32.3274 15.1362 32.0092C14.8388 31.6911 14.6714 31.273 14.667 30.8375C14.675 30.4157 14.8474 30.0138 15.1476 29.7174C15.4477 29.421 15.8518 29.2535 16.2737 29.2508H21.2297L26.1843 20.7895L23.7737 16.5588C23.7383 16.5588 23.7044 16.5448 23.6794 16.5198C23.6544 16.4948 23.6403 16.4609 23.6403 16.4255C23.5196 16.2384 23.4408 16.0274 23.4092 15.8069C23.3776 15.5865 23.394 15.3619 23.4573 15.1484C23.5206 14.9349 23.6293 14.7376 23.776 14.57C23.9226 14.4025 24.1038 14.2686 24.307 14.1775C24.5077 14.0735 24.7275 14.0116 24.9529 13.9954C25.1784 13.9793 25.4047 14.0094 25.6181 14.0838C25.8316 14.1582 26.0276 14.2753 26.1942 14.4281C26.3608 14.5808 26.4944 14.766 26.587 14.9722L28.0603 17.4842L29.527 14.9722L29.6603 14.8388C29.8978 14.4737 30.2671 14.2143 30.6912 14.1149C31.1153 14.0156 31.5614 14.0838 31.9363 14.3055C32.1295 14.408 32.2986 14.5504 32.4323 14.7235C32.5661 14.8965 32.6614 15.096 32.7118 15.3088C32.7623 15.5215 32.7668 15.7426 32.7251 15.9573C32.6833 16.1719 32.5962 16.3752 32.4697 16.5535L24.9803 29.2508H27.6577C28.1025 29.2501 28.5387 29.3735 28.9172 29.6072C29.2958 29.8409 29.6016 30.1755 29.8003 30.5735L31.0003 32.5562H16.2737Z"
                                                fill="#242424" />
                                        </g>
                                        <path
                                            d="M54.068 8.504H50.9V17H54.092C56.324 17 58.328 15.488 58.328 12.752C58.328 10.076 56.396 8.504 54.068 8.504ZM53.828 16.064H51.908V9.44H53.828C55.94 9.44 57.248 10.604 57.248 12.752C57.248 14.912 55.952 16.064 53.828 16.064ZM62.4585 11.24C60.6945 11.24 59.4585 12.476 59.4585 14.192C59.4585 15.92 60.7185 17.144 62.4585 17.144C64.1985 17.144 65.4585 15.92 65.4585 14.192C65.4585 12.452 64.1985 11.24 62.4585 11.24ZM60.4665 14.192C60.4665 13.004 61.2705 12.104 62.4465 12.104C63.6585 12.104 64.4505 13.004 64.4505 14.192C64.4505 15.38 63.6585 16.28 62.4585 16.28C61.2825 16.28 60.4665 15.404 60.4665 14.192ZM68.0115 17H68.9715L70.3875 12.68H70.4115L72.0075 17H72.9315L74.7435 11.384H73.7355L72.4635 15.704H72.4395L70.9635 11.384H69.9795L68.5275 15.704H68.5035L67.2195 11.384H66.1875L68.0115 17ZM75.7541 11.384C75.7541 11.72 75.8021 12.26 75.8021 12.632V17H76.7381V14.252C76.7381 12.908 77.3261 12.104 78.4781 12.104C79.3781 12.104 79.7621 12.728 79.7621 13.592V17H80.6981V13.484C80.6981 12.128 79.9901 11.24 78.5621 11.24C77.7341 11.24 76.9901 11.672 76.6901 12.308H76.6661C76.6661 11.936 76.6421 11.732 76.6421 11.384H75.7541ZM83.49 7.928H82.554V17H83.49V7.928ZM88.0288 11.24C86.2648 11.24 85.0288 12.476 85.0288 14.192C85.0288 15.92 86.2888 17.144 88.0288 17.144C89.7688 17.144 91.0288 15.92 91.0288 14.192C91.0288 12.452 89.7688 11.24 88.0288 11.24ZM86.0368 14.192C86.0368 13.004 86.8408 12.104 88.0168 12.104C89.2288 12.104 90.0208 13.004 90.0208 14.192C90.0208 15.38 89.2288 16.28 88.0288 16.28C86.8528 16.28 86.0368 15.404 86.0368 14.192ZM94.2418 17.144C95.0218 17.144 95.6698 16.796 96.0898 16.16H96.1138C96.1138 16.64 96.1258 16.856 96.1738 17H97.0738C97.0138 16.616 96.9898 16.268 96.9898 16.076V13.556C96.9898 12.02 96.2578 11.24 94.6378 11.24C93.8098 11.24 92.9818 11.528 92.4058 12.104L92.9938 12.716C93.4378 12.296 94.0498 12.104 94.6618 12.104C95.5378 12.104 96.0538 12.524 96.0538 13.352V13.508H95.6218C93.1258 13.508 92.1538 14.18 92.1538 15.476C92.1538 16.496 93.0178 17.144 94.2418 17.144ZM95.0218 14.3H96.0538V14.516C96.0538 15.716 95.3698 16.352 94.3978 16.352C93.6058 16.352 93.1618 16.016 93.1618 15.38C93.1618 14.648 93.9178 14.3 95.0218 14.3ZM101.185 17.144C102.109 17.144 102.961 16.712 103.345 16.004H103.369V17H104.305V7.928H103.369V12.2H103.345C102.829 11.588 102.121 11.24 101.329 11.24C99.5765 11.24 98.3765 12.488 98.3765 14.192C98.3765 15.86 99.6005 17.144 101.185 17.144ZM99.3845 14.192C99.3845 13.004 100.189 12.104 101.365 12.104C102.589 12.104 103.369 13.004 103.369 14.192C103.369 15.38 102.577 16.28 101.377 16.28C100.201 16.28 99.3845 15.404 99.3845 14.192ZM112.052 11.24C110.288 11.24 109.052 12.476 109.052 14.192C109.052 15.92 110.312 17.144 112.052 17.144C113.792 17.144 115.052 15.92 115.052 14.192C115.052 12.452 113.792 11.24 112.052 11.24ZM110.06 14.192C110.06 13.004 110.864 12.104 112.04 12.104C113.252 12.104 114.044 13.004 114.044 14.192C114.044 15.38 113.252 16.28 112.052 16.28C110.876 16.28 110.06 15.404 110.06 14.192ZM116.453 11.384C116.453 11.72 116.501 12.26 116.501 12.632V17H117.437V14.252C117.437 12.908 118.025 12.104 119.177 12.104C120.077 12.104 120.461 12.728 120.461 13.592V17H121.397V13.484C121.397 12.128 120.689 11.24 119.261 11.24C118.433 11.24 117.689 11.672 117.389 12.308H117.365C117.365 11.936 117.341 11.732 117.341 11.384H116.453ZM126.989 12.176V15.32C126.989 16.712 127.457 17.144 128.537 17.144C128.885 17.144 129.293 17.084 129.629 16.94L129.593 16.088C129.353 16.22 129.041 16.28 128.765 16.28C128.225 16.28 127.925 16.076 127.925 15.176V12.176H129.581V11.384H127.925V9.788H126.989V11.384H125.765V12.176H126.989ZM131.664 17V14.216C131.664 12.92 132.252 12.104 133.404 12.104C134.304 12.104 134.688 12.728 134.688 13.592V17H135.624V13.484C135.624 12.128 134.904 11.24 133.5 11.24C132.744 11.24 132.024 11.6 131.688 12.164H131.664V7.928H130.728V17H131.664ZM139.952 11.24C138.284 11.24 137.072 12.464 137.072 14.192C137.072 15.872 138.188 17.144 139.928 17.144C141.068 17.144 141.824 16.748 142.412 15.98L141.704 15.428C141.26 16.004 140.708 16.28 139.928 16.28C138.944 16.28 138.176 15.524 138.08 14.48H142.616V14.252C142.616 12.164 141.416 11.24 139.952 11.24ZM141.608 13.688H138.08C138.224 12.668 138.944 12.104 139.904 12.104C140.948 12.104 141.56 12.716 141.608 13.688Z"
                                            fill="#242424" />
                                        <path
                                            d="M51.974 38L52.87 35.732H57.168L58.092 38H60.108L55.838 28.088H54.312L50 38H51.974ZM55.026 30.188L56.552 34.22H53.472L55.026 30.188ZM65.0035 31.112C64.0935 31.112 63.2115 31.434 62.6795 32.288H62.6515V31.28H61.0555V41.192H62.7355V37.146H62.7775C63.3375 37.86 64.1635 38.168 65.0595 38.168C67.0475 38.168 68.3075 36.544 68.3075 34.64C68.3075 32.638 67.0335 31.112 65.0035 31.112ZM62.6795 34.64C62.6795 33.492 63.5195 32.624 64.6395 32.624C65.9555 32.624 66.6275 33.674 66.6275 34.64C66.6275 35.802 65.7875 36.656 64.6535 36.656C63.5615 36.656 62.6795 35.844 62.6795 34.64ZM73.8219 31.112C72.9119 31.112 72.0299 31.434 71.4979 32.288H71.4699V31.28H69.8739V41.192H71.5539V37.146H71.5959C72.1559 37.86 72.9819 38.168 73.8779 38.168C75.8659 38.168 77.1259 36.544 77.1259 34.64C77.1259 32.638 75.8519 31.112 73.8219 31.112ZM71.4979 34.64C71.4979 33.492 72.3379 32.624 73.4579 32.624C74.7739 32.624 75.4459 33.674 75.4459 34.64C75.4459 35.802 74.6059 36.656 73.4719 36.656C72.3799 36.656 71.4979 35.844 71.4979 34.64ZM86.2928 27.836C84.1368 27.836 82.6388 29.04 82.6388 30.832C82.6388 32.624 83.7868 33.226 85.5648 33.772C86.8388 34.164 87.3428 34.556 87.3428 35.298C87.3428 36.096 86.5588 36.656 85.6068 36.656C84.8088 36.656 84.0808 36.278 83.6468 35.62L82.3168 36.908C83.0868 37.832 84.2348 38.252 85.6348 38.252C87.5808 38.252 89.1908 37.132 89.1908 35.088C89.1908 33.044 87.6088 32.54 86.0268 32.05C85.0468 31.742 84.4868 31.378 84.4868 30.706C84.4868 29.936 85.1168 29.432 86.1108 29.432C86.7968 29.432 87.4548 29.67 87.8468 30.216L89.1348 28.858C88.4348 28.2 87.4268 27.836 86.2928 27.836ZM91.4759 32.708V35.858C91.4759 37.552 92.0919 38.168 93.6739 38.168C94.0519 38.168 94.6819 38.098 95.0039 37.944V36.53C94.8639 36.642 94.5139 36.74 94.0939 36.74C93.4359 36.74 93.1559 36.404 93.1559 35.69V32.708H95.0039V31.28H93.1559V29.334H91.4759V31.28H90.0899V32.708H91.4759ZM99.6333 31.112C97.5893 31.112 95.9793 32.554 95.9793 34.64C95.9793 36.74 97.5753 38.168 99.6333 38.168C101.691 38.168 103.287 36.74 103.287 34.64C103.287 32.54 101.691 31.112 99.6333 31.112ZM97.6593 34.64C97.6593 33.492 98.4993 32.624 99.6193 32.624C100.767 32.624 101.607 33.478 101.607 34.64C101.607 35.76 100.809 36.656 99.6333 36.656C98.4993 36.656 97.6593 35.802 97.6593 34.64ZM104.86 38H106.54V34.5C106.54 33.604 107.072 32.708 108.346 32.708C108.598 32.708 108.836 32.75 109.158 32.834V31.21C108.934 31.154 108.808 31.112 108.556 31.112C107.674 31.112 106.932 31.574 106.568 32.344H106.54V31.28H104.86V38ZM113.374 31.112C111.316 31.112 109.72 32.554 109.72 34.64C109.72 36.74 111.316 38.168 113.374 38.168C114.522 38.168 115.488 37.72 116.216 36.824L115.012 35.914C114.536 36.502 113.962 36.824 113.206 36.824C112.24 36.824 111.512 36.194 111.4 35.228H116.524V34.752C116.524 32.722 115.502 31.112 113.374 31.112ZM111.4 33.968C111.526 33.016 112.128 32.372 113.122 32.372C114.116 32.372 114.83 32.918 114.844 33.968H111.4Z"
                                            fill="#242424" />
                                        <defs>
                                            <clipPath id="clip0_769_5719">
                                                <rect width="32" height="32" fill="white"
                                                    transform="translate(12 10)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                                <a href="{{ $data->page_content['app_promotion_section']['android_playstore_link'] }}">
                                    <svg width="156" height="52" viewBox="0 0 156 52" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect width="156" height="52" rx="8" fill="white" />
                                        <g clip-path="url(#clip0_769_5727)">
                                            <path
                                                d="M17.0667 40.5671L28.6667 27.2644L32.6667 31.9204L17.8667 40.5671C17.7428 40.6308 17.6059 40.665 17.4667 40.6671C17.3274 40.6653 17.1904 40.6311 17.0667 40.5671ZM16 12.7644L27.6 25.9337L16 39.1044V12.7644ZM29.7333 25.9337L34.1333 21.1444L40.8 25.0031C40.9708 25.0491 41.119 25.1556 41.2172 25.3027C41.3153 25.4499 41.3566 25.6277 41.3333 25.8031V26.2031C41.3112 26.3682 41.2516 26.5261 41.1592 26.6647C41.0668 26.8034 40.9439 26.9191 40.8 27.0031L34.1333 30.8617L29.7333 25.9337ZM17.0667 11.4337C17.1898 11.3682 17.3272 11.334 17.4667 11.334C17.6062 11.334 17.7435 11.3682 17.8667 11.4337L32.6667 20.2137L28.6667 24.7364L17.0667 11.4337Z"
                                                fill="#242424" />
                                        </g>
                                        <path
                                            d="M55.136 8.288C52.496 8.288 50.564 10.172 50.564 12.752C50.564 15.392 52.46 17.216 55.1 17.216C56.204 17.216 57.284 16.964 58.28 16.424V12.248H55.316V13.184H57.272V15.788C56.684 16.076 55.88 16.28 55.16 16.28C53.096 16.28 51.644 14.792 51.644 12.752C51.644 10.724 53.108 9.224 55.064 9.224C55.94 9.224 56.792 9.572 57.38 10.196L58.136 9.404C57.404 8.672 56.396 8.288 55.136 8.288ZM62.7838 11.24C61.1158 11.24 59.9038 12.464 59.9038 14.192C59.9038 15.872 61.0198 17.144 62.7598 17.144C63.8998 17.144 64.6558 16.748 65.2438 15.98L64.5358 15.428C64.0918 16.004 63.5398 16.28 62.7598 16.28C61.7758 16.28 61.0078 15.524 60.9118 14.48H65.4478V14.252C65.4478 12.164 64.2478 11.24 62.7838 11.24ZM64.4398 13.688H60.9118C61.0558 12.668 61.7758 12.104 62.7358 12.104C63.7798 12.104 64.3918 12.716 64.4398 13.688ZM67.3758 12.176V15.32C67.3758 16.712 67.8438 17.144 68.9238 17.144C69.2718 17.144 69.6798 17.084 70.0158 16.94L69.9798 16.088C69.7398 16.22 69.4278 16.28 69.1518 16.28C68.6118 16.28 68.3118 16.076 68.3118 15.176V12.176H69.9678V11.384H68.3118V9.788H67.3758V11.384H66.1518V12.176H67.3758ZM75.0064 8.504C74.6344 8.504 74.3224 8.804 74.3224 9.188C74.3224 9.584 74.6104 9.872 75.0064 9.872C75.4024 9.872 75.6904 9.584 75.6904 9.188C75.6904 8.804 75.3784 8.504 75.0064 8.504ZM75.4744 11.384H74.5384V17H75.4744V11.384ZM77.2892 11.384C77.2892 11.72 77.3372 12.26 77.3372 12.632V17H78.2732V14.252C78.2732 12.908 78.8612 12.104 80.0132 12.104C80.9132 12.104 81.2972 12.728 81.2972 13.592V17H82.2332V13.484C82.2332 12.128 81.5252 11.24 80.0972 11.24C79.2692 11.24 78.5252 11.672 78.2252 12.308H78.2012C78.2012 11.936 78.1772 11.732 78.1772 11.384H77.2892ZM90.021 11.24C88.257 11.24 87.021 12.476 87.021 14.192C87.021 15.92 88.281 17.144 90.021 17.144C91.761 17.144 93.021 15.92 93.021 14.192C93.021 12.452 91.761 11.24 90.021 11.24ZM88.029 14.192C88.029 13.004 88.833 12.104 90.009 12.104C91.221 12.104 92.013 13.004 92.013 14.192C92.013 15.38 91.221 16.28 90.021 16.28C88.845 16.28 88.029 15.404 88.029 14.192ZM94.422 11.384C94.422 11.72 94.47 12.26 94.47 12.632V17H95.406V14.252C95.406 12.908 95.994 12.104 97.146 12.104C98.046 12.104 98.43 12.728 98.43 13.592V17H99.366V13.484C99.366 12.128 98.658 11.24 97.23 11.24C96.402 11.24 95.658 11.672 95.358 12.308H95.334C95.334 11.936 95.31 11.732 95.31 11.384H94.422Z"
                                            fill="#242424" />
                                        <path
                                            d="M55.824 27.836C52.702 27.836 50.574 29.964 50.574 33.086C50.574 36.152 52.744 38.252 55.824 38.252C57.21 38.252 58.596 37.972 59.912 37.272V32.204H56.118V33.8H58.148V36.138C57.448 36.53 56.58 36.656 55.838 36.656C53.71 36.656 52.422 35.018 52.422 32.974C52.422 31 53.794 29.432 55.824 29.432C56.748 29.432 57.742 29.754 58.414 30.398L59.716 29.082C58.666 28.13 57.196 27.836 55.824 27.836ZM65.1665 31.112C63.1225 31.112 61.5125 32.554 61.5125 34.64C61.5125 36.74 63.1085 38.168 65.1665 38.168C67.2245 38.168 68.8205 36.74 68.8205 34.64C68.8205 32.54 67.2245 31.112 65.1665 31.112ZM63.1925 34.64C63.1925 33.492 64.0325 32.624 65.1525 32.624C66.3005 32.624 67.1405 33.478 67.1405 34.64C67.1405 35.76 66.3425 36.656 65.1665 36.656C64.0325 36.656 63.1925 35.802 63.1925 34.64ZM73.7114 31.112C71.6674 31.112 70.0574 32.554 70.0574 34.64C70.0574 36.74 71.6534 38.168 73.7114 38.168C75.7694 38.168 77.3654 36.74 77.3654 34.64C77.3654 32.54 75.7694 31.112 73.7114 31.112ZM71.7374 34.64C71.7374 33.492 72.5774 32.624 73.6974 32.624C74.8454 32.624 75.6854 33.478 75.6854 34.64C75.6854 35.76 74.8874 36.656 73.7114 36.656C72.5774 36.656 71.7374 35.802 71.7374 34.64ZM81.9063 31.112C79.8623 31.112 78.6023 32.624 78.6023 34.64C78.6023 36.586 79.9743 38.084 81.9483 38.084C82.8163 38.084 83.6283 37.762 84.1463 37.104H84.1743V37.538C84.1743 39.036 83.6143 39.848 82.0463 39.848C81.1223 39.848 80.4083 39.498 79.7363 38.882L78.7283 40.254C79.6663 41.08 80.8003 41.36 82.0603 41.36C84.5943 41.36 85.8543 39.876 85.8543 37.454V31.28H84.2583V32.288H84.2303C83.7263 31.462 82.8443 31.112 81.9063 31.112ZM80.2823 34.626C80.2823 33.436 81.0943 32.624 82.2563 32.624C83.4463 32.624 84.2583 33.366 84.2583 34.598C84.2583 35.774 83.4323 36.572 82.2563 36.572C81.1783 36.572 80.2823 35.746 80.2823 34.626ZM89.4647 27.416H87.7847V38H89.4647V27.416ZM94.7114 31.112C92.6534 31.112 91.0574 32.554 91.0574 34.64C91.0574 36.74 92.6534 38.168 94.7114 38.168C95.8594 38.168 96.8254 37.72 97.5534 36.824L96.3494 35.914C95.8734 36.502 95.2994 36.824 94.5434 36.824C93.5774 36.824 92.8494 36.194 92.7374 35.228H97.8614V34.752C97.8614 32.722 96.8394 31.112 94.7114 31.112ZM92.7374 33.968C92.8634 33.016 93.4654 32.372 94.4594 32.372C95.4534 32.372 96.1674 32.918 96.1814 33.968H92.7374ZM105.493 38V33.898H106.851C109.497 33.898 110.715 33.002 110.715 30.93C110.715 28.452 108.405 28.088 107.131 28.088H103.729V38H105.493ZM105.493 29.6H106.809C108.181 29.6 108.867 30.048 108.867 30.986C108.867 32.274 107.677 32.386 106.641 32.386H105.493V29.6ZM113.842 27.416H112.162V38H113.842V27.416ZM117.772 38.168C118.668 38.168 119.452 37.832 119.928 37.076H119.97V38H121.482V33.982C121.482 32.4 120.908 31.112 118.612 31.112C117.296 31.112 116.358 31.574 115.756 32.19L116.638 33.072C117.1 32.652 117.73 32.372 118.43 32.372C119.354 32.372 119.97 32.834 119.97 33.618V33.814H119.452C116.568 33.814 115.322 34.598 115.322 36.152C115.322 37.384 116.386 38.168 117.772 38.168ZM119.382 34.99H119.872V35.41C119.872 36.264 119.34 36.908 118.192 36.908C117.562 36.908 117.002 36.6 117.002 36.026C117.002 35.312 117.898 34.99 119.382 34.99ZM122.38 31.28L125.25 38.056L124.956 38.784C124.648 39.526 124.48 39.848 123.598 39.848C123.304 39.848 123.01 39.778 122.744 39.68L122.534 41.192C122.954 41.304 123.388 41.36 123.822 41.36C125.502 41.36 125.95 40.534 126.496 39.148L129.562 31.28H127.812L126.132 35.942H126.104L124.228 31.28H122.38Z"
                                            fill="#242424" />
                                        <defs>
                                            <clipPath id="clip0_769_5727">
                                                <rect width="32" height="32" fill="white"
                                                    transform="translate(12 10)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="col-span-12 md:col-span-7 lg:col-span-6">
                            <div class="flex justify-center md:justify-end">
                                <img class="md:-mt-24 md:mb-24 w-[50%] md:w-[200px] xl:w-[300px] h-auto object-contain"
                                    src="{{ asset('/uploads/' . $data->page_content['app_promotion_section']['app_preview_1']) }}"
                                    alt="{{ __('Mobile App Preview') }}" />
                                <img class="md:-mb-24 md:mt-24 w-[50%] md:w-[200px] xl:w-[300px] h-auto object-contain"
                                    src="{{ asset('/uploads/' . $data->page_content['app_promotion_section']['app_preview_2']) }}"
                                    alt="{{ __('Mobile App Preview') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if (isset($data->page_content['gtrip_section']))
            <section class="mt-24">
                <div class="max-w-screen-xl mx-auto px-8 py-4">
                    <div class="grid grid-cols-12 items-center bg-gray-100 rounded-xl p-8 gap-y-12 md:gap-x-8">
                        <div class="col-span-12 md:col-span-6">
                            <div class="text-sm text-red-600">{{ __($data->page_content['gtrip_section']['subtitle']) }}
                            </div>
                            <div class="font-roman text-3xl font-bold mb-3">
                                {{ __($data->page_content['gtrip_section']['title']) }}</div>
                            <div class="text-sm mb-4">
                                {{ __($data->page_content['gtrip_section']['description']) }}
                            </div>
                            <x-filament::button tag="a"
                                href="{{ $data->page_content['gtrip_section']['cta_link'] }}">{{ __($data->page_content['gtrip_section']['cta_name']) }}</x-filament::button>
                        </div>
                        <div class="col-span-12 md:col-span-6">
                            <div class="relative">
                                <img class="relative w-full z-10"
                                    src="{{ asset('/uploads/' . $data->page_content['gtrip_section']['thumbnail']) }}"
                                    alt="{{ __('G-trip image') }}" />
                                <div class="absolute -top-5 -left-5 w-12 h-12 rounded-full bg-red-600/40"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif


        <!--- BELOW THIS NEED TO BE REFACTORED --->

        @if (count($agencies) > 0)
            <section>
                <div class="max-w-screen-xl mx-auto px-8 py-12">
                    <div class="mb-6">
                        @if (isset($data->page_content['travel_agent_section']['subtitle']))
                            <span
                                class="text-sm text-red-600">{{ __($data->page_content['travel_agent_section']['subtitle']) }}</span>
                        @endif
                        @if (isset($data->page_content['travel_agent_section']['title']))
                            <h2 class="font-roman text-3xl font-bold">
                                {!! __($data->page_content['travel_agent_section']['title']) !!}
                            </h2>
                        @endif
                    </div>
                    <div class="travel-agents-section splide"
                        aria-label="{{ __('Exclusive deals and special offers for you') }}">
                        <div class="splide__track">
                            <ul class="splide__list">
                                @foreach ($agencies as $key => $item)
                                    <li wire:key="{{ $key }}" class="splide__slide">
                                        <livewire:cards.agent-card :item="$item" />
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

        @if (isset($data->page_content['become_a_partner_section']))
            <section>
                <div class="max-w-screen-xl mx-auto px-8 pb-12">
                    <div class="rounded-lg bg-[#013663]">
                        <div class="grid grid-cols-12 items-center gap-y-4 md:gap-x-4 p-8">
                            <div class="col-span-12 md:col-span-6 text-white">
                                <h2 class="font-bold text-3xl font-roman">
                                    {{ __($data->page_content['become_a_partner_section']['title']) }}</h2>
                                <p class="text-sm mt-2">
                                    {{ __( $data->page_content['become_a_partner_section']['subtitle']) }}
                                </p>
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <div class="flex items-center justify-end gap-x-2">
                                    <a href="{{ $data->page_content['become_a_partner_section']['cta_link_1'] }}"
                                        class="px-5 py-3 bg-white rounded-lg text-[#013663] text-sm font-medium transition-all duration-200 hover:opacity-80">{{ __($data->page_content['become_a_partner_section']['cta_name_1']) }}</a>
                                    <a href="{{ $data->page_content['become_a_partner_section']['cta_link_2'] }}"
                                        class="px-5 py-[10px] border rounded-lg text-white text-sm font-medium transition-all duration-200 hover:opacity-80">{{ __($data->page_content['become_a_partner_section']['cta_name_2']) }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- How Does It Works -->
        <section x-data="">
            <div class="max-w-screen-xl mx-auto px-8 pn-12">
                <div class="text-center">
                    @if (isset($data->page_content['how_does_it_work_section']['subtitle']))
                        <div class="text-red-600">{{ __($data->page_content['how_does_it_work_section']['subtitle']) }}</div>
                    @endif
                    @if (isset($data->page_content['how_does_it_work_section']['title']))
                        <h2 class="text-3xl font-bold font-roman">
                            {{ __($data->page_content['how_does_it_work_section']['title']) }}</h2>
                    @endif
                </div>
                <div class="grid grid-cols-12 gap-y-8 lg:gap-x-8 items-center mt-12">
                    @if (isset($data->page_content['how_does_it_work_section']['thumbnail']))
                        <div class="col-span-12 lg:col-span-6">
                            <button class="relative group w-full">
                                <img class="w-full rounded-xl aspect-[2/2] object-cover"
                                    src="{{ asset('/uploads/' . $data->page_content['how_does_it_work_section']['thumbnail']) }}"
                                    alt="" />
                                <div @click="$refs.how_does_it_work_vid_popup.classList.toggle('hidden')"
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

                        <!-- VIDE POPUP -->
                        <div x-ref="how_does_it_work_vid_popup" class="fixed w-screen h-screen top-0 right-0 z-50 hidden">
                            <div @click="$refs.how_does_it_work_vid_popup.classList.toggle('hidden')"
                                class="bg-gray-900/80 absolute w-full h-full hover:bg-red-800/80 transition-all duration-200">
                            </div>
                            <iframe
                                class="w-[400px] mx-auto mt-20 sm:w-[600px] rounded-xl relative shadow-xl aspect-[16/9] z-90"
                                src="{{ $data->page_content['how_does_it_work_section']['yt_video_link'] }}"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                    @endif
                    @if (isset($data->page_content['how_does_it_work_section']['content']))
                        <div class="col-span-12 lg:col-span-6">
                            <ul class="space-y-4">
                                @foreach ($data->page_content['how_does_it_work_section']['content'] as $item)
                                    <li>
                                        <div class="flex flex-col md:flex-row gap-4">
                                            <div class="rounded-lg w-16 sm:w-20 md:w-[8%] lg:w-[15%] xl:w-[12%]">
                                                <img class="w-full aspect-[2/2] object-contain rounded-lg"
                                                    src="{{ asset('/uploads/' . $item['icon']) }}"
                                                    alt="{{ __($item['title']) }} {{ __('Icon') }}" />
                                            </div>
                                            <div class="w-full md:w-[92%] lg:w-[85%] xl:w-[88%]">
                                                <h3 class="font-bold text-basic">
                                                    {{ __($item['title']) }}
                                                </h3>
                                                <p class="text-sm text-gray-800">
                                                    {{ __($item['description']) }}
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Why Travel Quoter -->
        <section class="mt-20">
            <div class="max-w-screen-xl mx-auto px-8">
                <div class="text-center">
                    @if (isset($data->page_content['why_us_section']['subtitle']))
                        <div class="text-red-600">{{ __($data->page_content['why_us_section']['subtitle']) }}</div>
                    @endif
                    @if (isset($data->page_content['why_us_section']['title']))
                        <h2 class="text-3xl font-bold font-roman">{{ __($data->page_content['why_us_section']['title']) }}
                        </h2>
                    @endif
                </div>
                @if (isset($data->page_content['why_us_section']['content']))
                    <div class="grid grid-cols-12 gap-4 mt-8">
                        @foreach ($data->page_content['why_us_section']['content'] as $item)
                            <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                                <div class="rounded-lg border h-full p-4 bg-white">
                                    <div class="rounded-lg mb-3">
                                        <img class="w-16 sm:w-20 aspect-[2/2] rounded-lg object-cover"
                                            src="{{ asset('/uploads/' . $item['icon']) }}"
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
        </section>

        <!-- Why Travel Quoter -->
        <section class="mt-20">
            <div class="max-w-screen-xl mx-auto px-8">
                <div class="text-center">
                    @if (isset($data->page_content['famous_place_section']['subtitle']))
                        <div class="text-red-600">{{ __($data->page_content['famous_place_section']['subtitle']) }}</div>
                    @endif
                    @if (isset($data->page_content['famous_place_section']['title']))
                        <h2 class="text-3xl font-bold font-roman">
                            {{ __($data->page_content['famous_place_section']['title']) }}</h2>
                    @endif
                </div>
                @if (isset($data->page_content['famous_place_section']['content']))
                    <div class="grid grid-cols-12 gap-4 mt-12">
                        @if (isset($data->page_content['famous_place_section']['content'][0]))
                            <div class="col-span-12 md:col-span-6">
                                <a href="{{ $data->page_content['famous_place_section']['content'][0]['redirect_link'] }}"
                                    class="block rounded-lg relative group overflow-hidden">
                                    <img class="aspect-[2/2] w-full rounded-lg transition-all duration-200 group-hover:scale-[1.4]"
                                        src="{{ asset('/uploads/' . $data->page_content['famous_place_section']['content'][0]['thumbnail']) }}"
                                        alt="{{ $data->page_content['famous_place_section']['content'][0]['name'] }} Image" />
                                    <div class="w-full h-full absolute top-0 right-0 rounded-lg z-40 bg-gray-900/60">
                                        <h3
                                            class="text-xl font-medium font-roman absolute top-[50%] z-40 text-gray-50 left-[50%] translate-y-[-50%] translate-x-[-50%]">
                                            {{ __($data->page_content['famous_place_section']['content'][0]['name']) }}
                                        </h3>
                                    </div>
                                </a>
                            </div>
                        @endif

                        <div class="col-span-12 md:col-span-6">
                            <div class="grid grid-cols-12 gap-4">
                                @foreach ($data->page_content['famous_place_section']['content'] as $key => $item)
                                    @if ($key != 0)
                                        <div class="col-span-6">
                                            <a href="{{ $item['redirect_link'] }}"
                                                class="block rounded-lg relative group overflow-hidden">
                                                <img class="aspect-[2/2] w-full rounded-lg transition-all duration-200 group-hover:scale-[1.4]"
                                                    src="{{ asset('/uploads/' . $item['thumbnail']) }}"
                                                    alt="{{ __($item['name']) }} {{ __('image') }}" />
                                                <div
                                                    class="w-full h-full absolute top-0 right-0 rounded-lg z-40 bg-gray-900/60">
                                                    <h3
                                                        class="text-xl font-medium font-roman absolute top-[50%] z-40 text-gray-50 left-[50%] translate-y-[-50%] translate-x-[-50%]">
                                                        {{ __($item['name']) }}
                                                    </h3>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                    </div>
                @endif
            </div>
        </section>
        <div class="py-12"></div>
    </main>
@stop
