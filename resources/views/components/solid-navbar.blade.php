<nav id="solid-navbar-wrapper" x-data="" class="relative bg-[#003663] w-full z-50">
    <div class="mx-auto max-w-screen-xl px-8 py-4">
        <div class="flex items-center justify-between">
            <ul class="flex items-center gap-x-8">
                <li class="mr-4">
                    <a href="{{ route('home', app()->getLocale()) }}" class="cursor-pointer">
                        <img class="h-10"
                            @if (isset($setting->config['logo'])) src="{{ asset('/uploads/' . $setting->config['logo']) }}" @else src="{{ asset('img/icons/logo-white-icon.svg') }}" @endif
                            alt="{{ __('Travel Quoter Logo') }}" />
                    </a>
                </li>
                <li class="hidden lg:block">
                    <a href="{{ route('home', app()->getLocale()) }}"
                        class="cursor-pointer text-sm text-white hover:text-white/70 focus:text-white/70">{{ __('Home') }}</a>
                </li>
                <li class="hidden lg:block">
                    <a href="{{ route('alerts', app()->getLocale()) }}"
                        class="cursor-pointer text-sm text-white hover:text-white/70 focus:text-white/70">{{ __('Travel Alerts') }}</a>
                </li>
                <li class="hidden lg:block">
                    <a href="{{ route('offers', app()->getLocale()) }}"
                        class="cursor-pointer text-sm text-white hover:text-white/70 focus:text-white/70">{{ __('Offers') }}</a>
                </li>
                <li class="hidden lg:block">
                    <a href="{{ route('about', app()->getLocale()) }}"
                        class="cursor-pointer text-sm text-white hover:text-white/70 focus:text-white/70">{{ __('About Us') }}</a>
                </li>
                <li class="hidden lg:block">
                    <a href="{{ route('contact', app()->getLocale()) }}"
                        class="cursor-pointer text-sm text-white hover:text-white/70 focus:text-white/70">{{ __('Contact Us') }}</a>
                </li>
            </ul>
            <ul class="flex items-center gap-x-4">
                <li class="hidden md:block">
                    @if (Auth::guard('client')->check())
                        <x-filament::dropdown size="lg" placement="top-start">
                            <x-slot name="trigger">
                                <x-filament::button size="xl" color="gray">
                                    <x-filament::icon class="w-5 h-5" icon="heroicon-s-user" />
                                </x-filament::button>
                            </x-slot>

                            <x-filament::dropdown.list>
                                <x-filament::dropdown.list.item icon="heroicon-s-user" tag="a"
                                    href="{{ route('filament.client.pages.dashboard', ['locale' => app()->getLocale(), 'tab' => 'my-information']) }}">
                                    My information
                                </x-filament::dropdown.list.item>

                                <x-filament::dropdown.list.item icon="heroicon-s-list-bullet" tag="a"
                                    href="{{ route('filament.client.pages.dashboard', ['locale' => app()->getLocale(), 'tab' => 'my-quotes']) }}">
                                    My quotes
                                </x-filament::dropdown.list.item>

                                <x-filament::dropdown.list.item icon="heroicon-s-user-group" tag="a"
                                    href="{{ route('filament.client.pages.dashboard', ['locale' => app()->getLocale(), 'tab' => 'g-trip']) }}">
                                    G-trip
                                </x-filament::dropdown.list.item>

                                <x-filament::dropdown.list.item icon="heroicon-s-check" tag="a"
                                    href="{{ route('filament.client.pages.dashboard', ['locale' => app()->getLocale(), 'tab' => 'subscriptions']) }}">
                                    Subscriptions
                                </x-filament::dropdown.list.item>

                                <x-filament::dropdown.list.item icon="heroicon-s-document-text" tag="a"
                                    href="{{ route('filament.client.pages.dashboard', ['locale' => app()->getLocale(), 'tab' => 'my-documents']) }}">
                                    My documents
                                </x-filament::dropdown.list.item>

                                <x-filament::dropdown.list.item icon="heroicon-s-bookmark" tag="a"
                                    href="{{ route('filament.client.pages.dashboard', ['locale' => app()->getLocale(), 'tab' => 'bookmarks']) }}">
                                    Bookmarks
                                </x-filament::dropdown.list.item>

                                <x-filament::dropdown.list.item icon="heroicon-s-cog-8-tooth" tag="a"
                                    href="{{ route('filament.client.pages.dashboard', ['locale' => app()->getLocale(), 'tab' => 'settings']) }}">
                                    Settings
                                </x-filament::dropdown.list.item>

                                <x-filament::dropdown.list.item icon="heroicon-s-banknotes" tag="a"
                                    href="{{ route('agent-membership', app()->getLocale()) }}">
                                    Become a Partner
                                </x-filament::dropdown.list.item>
                            </x-filament::dropdown.list>
                        </x-filament::dropdown>
                    @else
                        <a href="{{ route('filament.client.auth.login', app()->getLocale()) }}"
                            class="cursor-pointer text-sm text-white underline hover:text-white/70 focus:text-white/70">{{ __('Register/Login') }}</a>
                    @endif
                </li>
                @if (!Auth::guard('client')->Check())
                    <li class="hidden sm:block">
                        <a href="{{ route('agent-membership', app()->getLocale()) }}"
                            class="rounded-lg bg-white px-4 py-3 text-sm font-medium text-[#1C4C74] transition-all duration-200 hover:opacity-90">
                            {{ __('Become Partner?') }}
                        </a>
                    </li>
                @endif
                <li class="w-[60px]">
                    <livewire:cards.lang-changer />
                </li>
                @if (Auth::guard('client')->check())
                    <li class="md:hidden">
                        <a href="{{ route('filament.client.pages.dashboard', app()->getLocale()) }}"
                            class="flex items-center gap-x-1 rounded-lg bg-white p-3 text-sm font-medium text-[#1C4C74] transition-all duration-200 hover:opacity-90">
                            <x-filament::icon class="w-5 h-5" icon="heroicon-s-user" />
                        </a>
                    </li>
                @endif
                <li class="lg:hidden">
                    <button aria-label="menu"
                        x-on:click="
            document.querySelector('#sidenavbar').classList.remove('w-0');
            document.querySelector('#sidenavbar').classList.add('w-full');
            "
                        class="flex items-center gap-x-1 rounded-lg bg-white p-3 text-sm font-medium text-[#1C4C74] transition-all duration-200 hover:opacity-90">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <div id="sidenavbar" class="duration-400 fixed top-0 right-0 z-[9999] h-full w-0 overflow-x-hidden transition-all">
        <div x-on:click="
        document.querySelector('#sidenavbar').classList.add('w-0');
        document.querySelector('#sidenavbar').classList.remove('w-full');
        "
            class="absolute right-0 top-0 z-[9999] h-full w-full backdrop-blur-lg"></div>
        <div class="absolute right-0 top-0 z-[9999] h-full w-[300px] border-l border-[#002E56] bg-[#003663] shadow-lg">
            <div class="flex items-center justify-between border-b border-[#002E56] p-4">
                <a href="{{ route('home', app()->getLocale()) }}" class="cursor-pointer">
                    <img class="h-8"
                        @if (isset($setting->config['logo'])) src="{{ asset('/uploads/' . $setting->config['logo']) }}" @else src="{{ asset('img/icons/logo-white-icon.svg') }}" @endif
                        alt="TravelQuoter Logo" />
                </a>
                <button aria-label="close"
                    x-on:click="
                document.querySelector('#sidenavbar').classList.add('w-0');
                document.querySelector('#sidenavbar').classList.remove('w-full');
                "
                    class="text-white hover:text-50/70">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
            </div>
            <div class="border-b border-[#002E56] p-4">
                <ul class="flex flex-col gap-y-3">
                    <li>
                        <a href="{{ route('home', app()->getLocale()) }}"
                            class="cursor-pointer text-sm text-white hover:text-white/80">{{ __('Home') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('alerts', app()->getLocale()) }}"
                            class="cursor-pointer text-sm text-white hover:text-white/80">{{ __('Travel Alerts') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('offers', app()->getLocale()) }}"
                            class="cursor-pointer text-sm text-white hover:text-white/80">{{ __('Offers') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('about', app()->getLocale()) }}"
                            class="cursor-pointer text-sm text-white hover:text-white/80">{{ __('About Us') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('contact', app()->getLocale()) }}"
                            class="cursor-pointer text-sm text-white hover:text-white/80">{{ __('Contact Us') }}</a>
                    </li>
                </ul>
            </div>
            <div class="p-4">
                <a href="{{ route('filament.client.auth.login', app()->getLocale()) }}"
                    class="flex cursor-pointer items-center justify-center gap-x-2 rounded-lg bg-gray-900 px-3 py-3 text-sm font-medium text-gray-50 hover:bg-gray-900/70">
                    <span>{{ __('Register / Login') }}</span>
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                    </svg>
                </a>
                <a href="{{ route('agent-membership', app()->getLocale()) }}"
                    class="mt-3 block text-center rounded-lg bg-white px-3 py-3 text-sm font-medium text-[#003663] hover:bg-white/80">
                    {{ __('Become a Partner?') }}
                </a>
            </div>
        </div>
    </div>
</nav>
