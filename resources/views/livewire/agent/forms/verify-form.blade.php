<div class="pb-12 pt-8 px-4">
    <h2 class="text-2xl font-bold my-4">{{ __('Verify Email') }}</h2>

    <form wire:submit="authenticate" class="py-10">
        <div class="mb-10">
            {{ $this->form }}
        </div>
        <x-filament::button type="submit" class="w-full" size="lg">{{ __('Verify Email') }}</x-filament::button>
    </form>

    <div class="flex items-center gap-x-2 w-full">
        <hr class="w-full">
        <span>OR</span>
        <hr class="w-full">
    </div>

    <div class="text-center">
        <p class="text-gray-700 mt-8">
            {{ __('Did not receive an verification mail. Then re-send a verification mail.') }}</p>
        <div class="mt-3 flex items-center gap-2 flex-wrap justify-center">
            <x-filament::button
                wire:click="resendVerificationMail">{{ __('Re-send verification mail') }}</x-filament::button>
            <x-filament::button wire:click="logout" color="danger">Logout</x-filament::button>
        </div>
    </div>
</div>
