<div>
    <div class="bg-[#f4faf9] w-full bg-repeat">
        <div class="max-w-screen-xl flex-wrap items-center justify-between mx-auto sm:px-10 px-4 pt-3">
            <div class="items-center text-gray-500 text-sm flex-wrap lg:gap-4 ">
                <div class="flex items-center gap-x-2">
                    <a href="{{ route('home') }}" class="hover:text-gray-700 ">{{ __('Home') }}</a>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-3 h-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                    <a class="hover:text-gray-700  text-[#013663]">{{ __('Faq') }}</a>
                </div>
            </div>
            <div class="py-10">
                <h2 class="text-2xl font-bold text-center">{{ __($page['title']) }}</h2>
                <p class="text-center">{{ __($page['subtitle']) }}</p>
            </div>
        </div>
    </div>

    <div class="max-w-screen-xl mx-auto px-6 py-12">
        <section>
            <h3 class="font-medium text-sm md:text-lg lg:text-xl text-center mb-4">{{ __('Choose an account type for
                personalized service') }}</h3>
            <div class="flex flex-wrap gap-4 items-center justify-center">
                @if ($account_type == 'Traveller')
                    <x-filament::button wire:click="changeAccountType('Traveller')" size="xl">{{ __('I\'m a
                        Traveller') }}</x-filament::button>
                    <x-filament::button wire:click="changeAccountType('Travel Agent')" size="xl" color="gray">{{ __('I\'m
                        a Travel Agent') }}</x-filament::button>
                @else
                    <x-filament::button wire:click="changeAccountType('Traveller')" size="xl" color="gray">{{ __('I\'m a
                        Traveller') }}</x-filament::button>
                    <x-filament::button wire:click="changeAccountType('Travel Agent')" size="xl">{{ __('I\'m a Travel
                        Agent') }}</x-filament::button>
                @endif
            </div>
        </section>

        <section>
            <div class="grid grid-cols-12 gap-6 mt-12">
                <div class="col-span-12 md:col-span-4 lg:col-span-3">
                    <div class="sticky top-0">
                        <x-filament::section>
                            <div class="space-y-3">
                            @foreach ($data as $item)
                                <x-filament::button class="block w-full text-left" tag="a"
                                    href="#{{ Str::slug($item->category) }}" color="gray">{{ __($item->category) }}</x-filament::button>
                            @endforeach
                            </div>
                        </x-filament::section>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-8 lg:col-span-9">
                    <div class="space-y-8">
                        @foreach ($data as $item)
                            @php
                                $all_questions = \App\Models\Faq::where('status', true)
                                    ->where('account_type', $account_type)
                                    ->where('category', $item->category)
                                    ->get();
                            @endphp

                            <div id="{{ Str::slug($item->category) }}">
                                <h3 class="font-medium text-sm md:text-lg mt-6 mb-3">{{ $item->category }}</h3>
                                @foreach ($all_questions as $question)
                                    <div class="mb-6">
                                        <x-filament::section collapsible>
                                            <x-slot name="heading">
                                                {{ __($question->question) }}
                                            </x-slot>

                                            <div>
                                                {!! __($question->answer) !!}
                                            </div>
                                        </x-filament::section>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>


    <div class="max-w-screen-xl sm:px-10 px-4 mx-auto my-12">
        <div
            class="bg-gray-100 shadow rounded-lg flex flex-col md:flex-row p-8 gap-3 md:justify-between md:items-center">
            <div class="">
                <h2 class="text-2xl font-semibold">{{ __( $page['page_content']['need_help_section']['title']) }}</h2>
                <p>{{ __($page['page_content']['need_help_section']['subtitle']) }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ $page['page_content']['need_help_section']['btn_1_link'] }}"
                    class="block px-6 py-3 bg-[#013663] rounded text-white font-medium transition-all duration-200 hover:opacity-90">{{ __($page['page_content']['need_help_section']['btn_1_label']) }}</a>
                <a href="{{ $page['page_content']['need_help_section']['btn_2_link'] }}"
                    class="block px-6 py-3 bg-white shadow rounded text-[#013663] font-medium transition-all duration-200 hover:opacity-90">{{ __($page['page_content']['need_help_section']['btn_2_label']) }}</a>
            </div>
        </div>
    </div>
</div>
