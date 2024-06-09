<!-- Footer Component -->
<footer class="bg-[#013663]">
    <div class="relative">
        <div class="mx-auto max-w-screen-xl px-8 pt-20 pb-20 relative z-20">
            <div class="grid grid-cols-12 gap-y-8 sm:gap-8">
                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4">
                    <div>
                        <a href="{{ route('home', app()->getLocale()) }}"
                            class="flex cursor-pointer items-center gap-x-1 text-gray-300 transition-all duration-300 hover:opacity-80">
                            <img class="w-44"
                                @if (isset($setting->config['logo'])) src="{{ asset('/uploads/' . $setting->config['logo']) }}" @else src="{{ asset('img/icons/logo-white-icon.svg') }}" @endif
                                alt="Travel Quoter Logo" />
                        </a>
                        <div class="mt-4 font-medium text-white">{{ __('Follow us') }}</div>
                        <ul class="mt-6 flex gap-6">
                            @if (isset($setting->config['linkedin']))
                                <li>
                                    <a href="{{ $setting->config['linkedin'] }}" rel="noreferrer"
                                        target="_blank"
                                        class="text-gray-300 transition hover:text-gray-300/60 focus:text-gray-300/60">
                                        <span class="sr-only">Linkedin</span>
                                        <img src="{{ asset('img/icons/linkedin-white-icon.svg') }}"
                                            alt="linkedin logo" />
                                    </a>
                                </li>
                            @endif

                            @if (isset($setting->config['facebook']))
                                <li>
                                    <a href="{{ $setting->config['facebook'] }}" rel="noreferrer"
                                        target="_blank"
                                        class="text-gray-300 transition hover:text-gray-300/60 focus:text-gray-300/60">
                                        <span class="sr-only">Facebook</span>
                                        <img src="{{ asset('img/icons/facebook-white-icon.svg') }}"
                                            alt="facebook logo" />
                                    </a>
                                </li>
                            @endif

                            @if (isset($setting->config['instagram']))
                                <li>
                                    <a href="{{ $setting->config['instagram'] }}" rel="noreferrer"
                                        target="_blank"
                                        class="text-gray-300 transition hover:text-gray-300/60 focus:text-gray-300/60">
                                        <span class="sr-only">{{ $setting->config['instagram'] }}</span>
                                        <img src="{{ asset('img/icons/instagram-white-icon.svg') }}"
                                            alt="instagram logo" />
                                    </a>
                                </li>
                            @endif

                            @if (isset($setting->config['tiktok']))
                                <li>
                                    <a href="{{ $setting->config['tiktok'] }}" rel="noreferrer"
                                        target="_blank"
                                        class="text-gray-300 transition hover:text-gray-300/60 focus:text-gray-300/60">
                                        <span class="sr-only">Tiktok</span>
                                        <img src="{{ asset('img/icons/tiktok-white-icon.svg') }}" alt="tiktok logo" />
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-4 md:col-span-4 lg:col-span-2">
                    <ul class="flex flex-col gap-y-2">
                        <li class="text-lg font-medium text-gray-200">{{ __('Quick Links') }}</li>
                        <li>
                            <a href="{{ route('home', app()->getLocale()) }}"
                                class="cursor-pointer text-sm text-gray-300 hover:text-gray-300/60">{{ __('Home') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('about', app()->getLocale()) }}"
                                class="cursor-pointer text-sm text-gray-300 hover:text-gray-300/60">{{ __('About Us') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('contact', app()->getLocale()) }}"
                                class="cursor-pointer text-sm text-gray-300 hover:text-gray-300/60">{{ __('Contact Us') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('why-us', app()->getLocale()) }}"
                                class="cursor-pointer text-sm text-gray-300 hover:text-gray-300/60">{{ __('Why Us') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('faq', app()->getLocale()) }}"
                                class="cursor-pointer text-sm text-gray-300 hover:text-gray-300/60">{{ __('FAQ') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="col-span-6 sm:col-span-4 md:col-span-4 lg:col-span-2">
                    <ul class="flex flex-col gap-y-2">
                        <li class="text-lg font-medium text-gray-200">{{ __('Our Services') }}</li>
                        <li>
                            <a href="{{ route('flight.step-1', app()->getLocale()) }}"
                                class="cursor-pointer text-sm text-gray-300 hover:text-gray-300/60">{{ __('Flights') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('hotel.step-1', app()->getLocale()) }}"
                                class="cursor-pointer text-sm text-gray-300 hover:text-gray-300/60">{{ __('Accommodation') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('car.step-1', app()->getLocale()) }}"
                                class="cursor-pointer text-sm text-gray-300 hover:text-gray-300/60">{{ __('Car Hire') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('cruise.step-1', app()->getLocale()) }}"
                                class="cursor-pointer text-sm text-gray-300 hover:text-gray-300/60">{{ __('Cruise') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('insurance.step-1', app()->getLocale()) }}"
                                class="cursor-pointer text-sm text-gray-300 hover:text-gray-300/60">{{ __('Insurance') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('visa.step-1', app()->getLocale()) }}"
                                class="cursor-pointer text-sm text-gray-300 hover:text-gray-300/60">{{ __('Visa') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="col-span-6 sm:col-span-4 md:col-span-4 lg:col-span-2">
                    <ul class="flex flex-col gap-y-2">
                        <li class="text-lg font-medium text-gray-200">{{ __('Travel') }}</li>
                        <li>
                            <a href="{{ route('blogs', app()->getLocale()) }}"
                                class="cursor-pointer text-sm text-gray-300 hover:text-gray-300/60">{{ __('Blogs') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('blogs', app()->getLocale()) }}"
                                class="cursor-pointer text-sm text-gray-300 hover:text-gray-300/60">{{ __('Articles') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('alerts', app()->getLocale()) }}"
                                class="cursor-pointer text-sm text-gray-300 hover:text-gray-300/60">{{ __('Alerts') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="col-span-6 sm:col-span-4 md:col-span-4 lg:col-span-2">
                    <ul class="flex flex-col gap-y-2">
                        <li class="text-lg font-medium text-gray-200">{{ __('Parents') }}</li>
                        <li>
                            <a href="{{ route('advertise-with-us', app()->getLocale()) }}"
                                class="cursor-pointer text-sm text-gray-300 hover:text-gray-300/60">{{ __('Advertise With
                                Us') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('agent-membership', app()->getLocale()) }}"
                                class="cursor-pointer text-sm text-gray-300 hover:text-gray-300/60">{{ __('Agent
                                Membership') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('offers', app()->getLocale()) }}"
                                class="cursor-pointer text-sm text-gray-300 hover:text-gray-300/60">{{ __('Offers') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 -z-1">
            <img class="w-screen h-auto" src="{{ asset('img/shapes/footer-shape.svg') }}" alt="{{ __('Footer Graphic') }}" />
        </div>
    </div>

    <div class="bg-[#03335C]">
        <div class="mx-auto max-w-screen-xl px-8 py-4">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-2">
                <div>
                    <ul class="flex items-center gap-x-2">
                        <li>
                            <a href="{{ route('terms-and-conditions', app()->getLocale()) }}"
                                class="cursor-pointer text-xs text-gray-300 hover:text-gray-300/60">{{ __('Terms and
                                Conditions') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('privacy-policy', app()->getLocale()) }}"
                                class="cursor-pointer text-xs text-gray-300 hover:text-gray-300/60">{{ __('Privacy
                                Policy') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="cursor-pointer text-xs text-gray-300">
                    @if (isset($setting->config['copyright']))
                        {!! __($setting->config['copyright']) !!}
                    @else
                        @copy; {{ __('2023 Travel Quoter, All Rights Reserved') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</footer>
