<div>
    @php
        if (Auth::guard('client')->check()) {
            $client = Auth::guard('client')->user();
            $has_subscribed = false;
            if (
                \App\Models\SubscribeAgent::where('client_id', $client->id)
                    ->where('agent_id', $story->agent->id)
                    ->first()
            ) {
                $has_subscribed = true;
            }
        }
    @endphp
    <x-filament::section>
        <div class="flex justify-between items-center flex-wrap gap-2">
            <div class="flex items-center gap-1">
                <x-filament::avatar size="w-12 h-12" src="{{ asset('uploads/' . $story->agent->profile_picture) }}" />
                <div>
                    <h1 class="font-medium">{{ __($story->agent->name) }}</h1>
                    <h3 class="text-sm text-primary-600">@
                        {{ __($story->agent->agency->agency_name) }}</h3>
                </div>
            </div>
            <div>
                @if (Auth::guard('client')->check())
                    @if ($has_subscribed)
                        <x-filament::button wire:click="subscribeToggle({{ $client->id }}, {{ $story->agent->id }})"
                            size="xs" outlined>{{ __('Unsubscribe') }}</x-filament::button>
                    @else
                        <x-filament::button wire:click="subscribeToggle({{ $client->id }}, {{ $story->agent->id }})"
                            size="xs" icon="heroicon-o-plus" outlined>{{ __('Subscribe') }}</x-filament::button>
                    @endif
                @else
                    <x-filament::button wire:click="subscribeToggle(0,0)" size="xs" icon="heroicon-o-plus"
                        outlined>{{ __('Subscribe') }}</x-filament::button>
                @endif
            </div>
        </div>
        <div class="text-sm text-primary-800 my-3">{{ __($story->content) }}</div>
        @if ($story->image)
            <div>
                <img class="w-full rounded-xl aspect-[5/3]" src="{{ asset('uploads/' . $story->image) }}"
                    alt="{{ __($story->content) }}" />
            </div>
        @endif
        <div class="flex items-center justify-between gap-2 py-3">
            <div class="flex items-center gap-x-3">
                <x-filament::icon-button icon="heroicon-o-hand-thumb-up" />
                <x-filament::icon-button icon="heroicon-o-chat-bubble-bottom-center" />
            </div>
            @if (Auth::guard('client')->check() || Auth::guard('agent')->check())
                <div>
                    <x-filament::icon-button icon="heroicon-o-paper-airplane" />
                </div>
            @endif
        </div>
        @if (Auth::guard('client')->check() || Auth::guard('agent')->check())
            <div class="flex items-center border rounded-full p-1 bg-gray-100">
                <x-filament::avatar size="w-8 h-8" src="{{ asset('uploads/10.jpg') }}" />
                <input type="text" class="text-sm border-none bg-gray-100 w-full focus:outline-none focus:ring-0"
                    placeholder="{{ __('Write a comment') }}" />
            </div>
        @endif
    </x-filament::section>
</div>
