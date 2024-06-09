<div class="w-full flex justify-between gap-1">
    <div>
        <h2 class="font-pop font-bold text-start text-sm ml-1 line-clamp-1">{{ __($item->agency_name) }}</h2>
        <p class="font-pop text-sm text-[#6F7787] line-clamp-1 ml-1">{{ __('@' . $item->agency_name) }}</p>
    </div>
    <div>
        @if (auth()->guard('client')->check())
            @if ($has_subscribed)
                <x-filament::button wire:click="subscribeToggle">{{ __('Unsubscribe') }}</x-filament::button>
            @else
                <x-filament::button wire:click="subscribeToggle">{{ __('Subscribe') }}</x-filament::button>
            @endif
        @else
            <x-filament::button wire:click="subscribeToggle">{{ __('Subscribe') }}</x-filament::button>
        @endif
    </div>
</div>