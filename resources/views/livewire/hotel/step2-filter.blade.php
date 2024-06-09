<section>
    <form wire:submit="submit">
        <div>
            {{ $this->form }}
        </div>
        <div class="flex items-center justify-between flex-wrap gap-3 mt-6 md:mt-8">
            <x-filament::button size="lg" tag="a" color="gray" href="{{ route('hotel.step-1') }}">{{ __('Back') }}</x-filament::button>
            <x-filament::button size="lg" type="submit">{{ __('Next') }}</x-filament::button>
        </div>
    </form>
</section>
