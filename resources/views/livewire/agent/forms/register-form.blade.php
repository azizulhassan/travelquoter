<div class="pb-12 pt-8 px-4">
    <h2 class="text-2xl font-bold my-4">{{ __('Register') }}</h2>

    <div class="rounded-lg border bg-white shadow p-2 flex items-center  gap-2">
        <a href="{{ route('filament.client.auth.register') }}"
            class="flex items-center justify-center block flex-1 gap-x-2 text-[#003663] font-medium rounded-lg px-3 py-2 transition-all duration-200 hover:bg-gray-200 focus:bg-gray-200 @if (Route::current()->getName() == 'filament.client.auth.register') bg-gray-200 @endif">
            <img class="w-6 h-6" src="{{ asset('img/icons/brifcase.svg') }}" alt="{{ __('Traveller') }}" />
            <span>{{ __('Traveller') }}</span>
        </a>
        <a href="{{ route('filament.agent.auth.register') }}"
            class="flex items-center justify-center block flex-1 gap-x-2 text-[#003663] font-medium rounded-lg px-3 py-2 transition-all duration-200 hover:bg-gray-200 focus:bg-gray-200 @if (Route::current()->getName() == 'filament.agent.auth.register') bg-gray-200 @endif">
            <img class="w-6 h-6" src="{{ asset('img/icons/globe-flight.svg') }}" alt="{{ __('Travel Agent') }}" />
            <span>{{ __('Travel Agent') }}</span>
        </a>
    </div>

    <form wire:submit="authenticate" class="py-10">
        <div class="mb-10">
            {{ $this->form }}
        </div>
        <x-filament::button type="submit" class="w-full" size="lg">{{ __('Register') }}</x-filament::button>
    </form>

    <div class="flex items-center gap-x-2 w-full">
        <hr class="w-full">
        <span>{{ __('OR') }}</span>
        <hr class="w-full">
    </div>

    <div class="flex justify-center items-center mb-6 gap-3 mt-4">
        <x-filament::button wire:click="socialMedia('facebook')" class="rounded-full" color="gray">
            <img src="http://127.0.0.1:8000/img/icons/facebook.svg" alt="{{ __('Facebook') }}" class=" mx-auto h-6 w-6" />
        </x-filament::button>
        <x-filament::button wire:click="socialMedia('google')" class="rounded-full" color="gray">
            <img src="http://127.0.0.1:8000/img/icons/google.svg" alt="{{ __('Google') }}" class=" mx-auto h-6 w-6" />
        </x-filament::button>
        <x-filament::button wire:click="socialMedia('x')" class="rounded-full" color="gray">
            <img src="http://127.0.0.1:8000/img/icons/twitter.svg" alt="{{ __('Twitter') }}" class=" mx-auto h-6 w-6" />
        </x-filament::button>
    </div>

    <div class="text-center">
        <p class="text-gray-700 mt-8">{{ __('Doesn\'t Have An Account?') }}
            <x-filament::link href="{{ route('filament.agent.auth.login') }}" color="danger">{{ __('Login') }}</x-filament::link>
        </p>
    </div>
</div>
