<div class="space-y-3">
    <div class="pb-3">
        <input wire:model.live="search"
            class="p-3 text-sm border rounded-lg border-gray-300 focus:outline-none focus:ring-[#003663] w-full"
            type="search" placeholder="{{ __('Write agency name.') }}" />
    </div>

    <div wire:loading.class.remove="hidden" class="hidden skeleton-loader w-full h-20 rounded-lg text-gray-600 flex items-center justify-center border">
        <span>{{ __('SEARCHING...') }}</span>
    </div>

    @if (count($agencies) > 0)
        @foreach ($agencies as $key => $item)
            <div class="border bg-white p-3 rounded-lg flex gap-2 shadow-sm">
                <div
                    class="w-[35px] h-[35px] bg-gray-200 flex items-center justify-center font-medium rounded-lg text-gray-600 mt-1.5 sm:mt-1">
                    {{ __($key + 1) }}</div>
                <livewire:cards.subscriber-card :item="$item" :key="$key" />
            </div>
        @endforeach
    @else
        <div class="border bg-white p-3 rounded-lg flex gap-2 text-gray-700">
            {{ __('Agency could not be found.') }}
        </div>
    @endif
</div>
