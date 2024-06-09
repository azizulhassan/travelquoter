<div>
    <div id="flight-tabs" x-data="{ tab: 'round-way' }">
        <x-filament::tabs>
            <x-filament::tabs.item @click="tab = 'round-way'" :alpine-active="'tab === \'round-way\''">
                <span class="inline-block px-4 py-1">Round-way</span>
            </x-filament::tabs.item>

            <x-filament::tabs.item @click="tab = 'one-way'" :alpine-active="'tab === \'one-way\''">
                <span class="inline-block px-4 py-1">One way</span>
            </x-filament::tabs.item>

            <x-filament::tabs.item @click="tab = 'multi-city'" :alpine-active="'tab === \'multi-city\''">
                <span class="inline-block px-4 py-1">Multi-city</span>
            </x-filament::tabs.item>
        </x-filament::tabs>

        <div>
            <div x-cloak x-show="tab === 'round-way'">
                <livewire:forms.round-way-flight-form flight_type="round-way" />
            </div>
            <div x-cloak x-show="tab === 'one-way'">
                <livewire:forms.one-way-flight-form flight_type="one-way" />
            </div>
            <div x-cloak x-show="tab === 'multi-city'">
                <livewire:forms.multi-city-flight-form fligiht_type="multi-city" />
            </div>
        </div>
    </div>
</div>
