<div>
    <livewire:client.cards.cover-card />

    <style>
        .fi-btn {
            justify-content: flex-start;
        }
    </style>

    <div class="grid grid-cols-12 gap-4 mt-6 md:mt-8">
        <div class="col-span-12 md:col-span-4 lg:col-span-3">
            <ul class="space-y-4 border bg-white p-6 rounded-xl shadow-am ring-1 ring-gray-950/10">
                <li>
                    @if ($tab == 'my-information')
                        <x-filament::button wire:click="changeTab('my-information')" icon="heroicon-s-user" color="primary"
                            class="w-full justify-start">My informations</x-filament::button>
                    @else
                        <x-filament::button wire:click="changeTab('my-information')" icon="heroicon-s-user" color="gray"
                            class="w-full justify-start">My informations</x-filament::button>
                    @endif
                </li>
                <li>
                    @if ($tab == 'my-quotes')
                        <x-filament::button wire:click="changeTab('my-quotes')" icon="heroicon-s-list-bullet"
                            color="primary" class="w-full">My quotes</x-filament::button>
                    @else
                        <x-filament::button wire:click="changeTab('my-quotes')" icon="heroicon-s-list-bullet"
                            color="gray" class="w-full">My quotes</x-filament::button>
                    @endif
                </li>
                <li>
                    @if ($tab == 'g-trip')
                        <x-filament::button wire:click="changeTab('g-trip')" icon="heroicon-s-user-group"
                            color="primary" class="w-full">G-trip</x-filament::button>
                    @else
                        <x-filament::button wire:click="changeTab('g-trip')" icon="heroicon-s-user-group" color="gray"
                            class="w-full">G-trip</x-filament::button>
                    @endif
                </li>
                <li>
                    @if ($tab == 'subscriptions')
                        <x-filament::button wire:click="changeTab('subscriptions')" icon="heroicon-s-check"
                            color="primary" class="w-full">Subscriptions</x-filament::button>
                    @else
                        <x-filament::button wire:click="changeTab('subscriptions')" icon="heroicon-s-check"
                            color="gray" class="w-full">Subscriptions</x-filament::button>
                    @endif
                </li>
                <li>
                    @if ($tab == 'my-documents')
                        <x-filament::button wire:click="changeTab('my-documents')" icon="heroicon-s-document-text"
                            color="primary" class="w-full">My documents</x-filament::button>
                    @else
                        <x-filament::button wire:click="changeTab('my-documents')" icon="heroicon-s-document-text"
                            color="gray" class="w-full">My documents</x-filament::button>
                    @endif
                </li>
                <li>
                    @if ($tab == 'bookmarks')
                        <x-filament::button wire:click="changeTab('bookmarks')" icon="heroicon-s-bookmark"
                            color="primary" class="w-full">Bookmarks</x-filament::button>
                    @else
                        <x-filament::button wire:click="changeTab('bookmarks')" icon="heroicon-s-bookmark"
                            color="gray" class="w-full">Bookmarks</x-filament::button>
                    @endif
                </li>
                <li>
                    @if ($tab == 'settings')
                        <x-filament::button wire:click="changeTab('settings')" icon="heroicon-s-cog-8-tooth"
                            color="primary" class="w-full">Settings</x-filament::button>
                    @else
                        <x-filament::button wire:click="changeTab('settings')" icon="heroicon-s-cog-8-tooth"
                            color="gray" class="w-full">Settings</x-filament::button>
                    @endif
                </li>
            </ul>
        </div>
        <div class="col-span-12 md:col-span-8 lg:col-span-9">
            @if ($tab == 'my-information')
                <div class="border bg-white p-6 rounded-xl shadow-am ring-1 ring-gray-950/10">
                    <livewire:client.forms.my-information-form />
                </div>
            @endif

            @if ($tab == 'my-quotes')
                <div class="border bg-white p-6 rounded-xl shadow-am ring-1 ring-gray-950/10">
                    <livewire:client.sections.my-quote-section />
                </div>
            @endif

            @if ($tab == 'g-trip')
                <div class="border bg-white p-6 rounded-xl shadow-am ring-1 ring-gray-950/10">
                    <livewire:client.sections.gtrip-section />
                </div>
            @endif

            @if ($tab == 'subscriptions')
                <div class="border bg-white p-6 rounded-xl shadow-am ring-1 ring-gray-950/10">
                    <livewire:client.sections.subscription-section />
                </div>
            @endif

            @if ($tab == 'my-documents')
                <div class="border bg-white p-6 rounded-xl shadow-am ring-1 ring-gray-950/10">
                    <livewire:client.sections.my-documents-section />
                </div>
            @endif

            @if ($tab == 'bookmarks')
                <div class="border bg-white p-6 rounded-xl shadow-am ring-1 ring-gray-950/10">
                    <livewire:client.sections.bookmark-section />
                </div>
            @endif

            @if ($tab == 'settings')
                <div class="border bg-white p-6 rounded-xl shadow-am ring-1 ring-gray-950/10">
                    <livewire:client.sections.setting-section />
                </div>
            @endif
        </div>
    </div>
</div>
