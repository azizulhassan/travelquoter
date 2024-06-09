<div>
    @if ($type == 1)
    <div class="flex items-end gap-x-1 w-full">
        <x-filament::avatar src={{$image}} />
        <div class="p-2 rounded-lg bg-gray-50 w-full">
            <p class="text-sm text-gray-800">{{ $message }}</p>
            <div class="text-xs text-gray-600">
                <span>{{ $name }}</span>
                <span>{{ $time }}</span>
            </div>
        </div>
    </div>
    @else
    <div class="flex items-end gap-x-1 w-full">
        <div class="p-2 rounded-lg bg-gray-100 w-full">
            <p class="text-sm text-gray-800">{{ $message }}</p>
            <div class="text-xs text-gray-600">
                <span>{{ $name }}</span>
                <span>{{ $time }}</span>
            </div>
        </div>
        <x-filament::avatar src={{$image}} />
    </div>
    @endif
</div>
