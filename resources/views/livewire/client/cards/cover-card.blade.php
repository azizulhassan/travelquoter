<div>
    <div class="rounded-lg">
        <div class="relative bg-gray-200 aspect-[6/2] w-full rounded-xl flex items-center justify-center">
            @if (isset($client->cover))
                <img class="w-full h-full object-cover rounded-xl" src="{{ asset('uploads/' . $client->cover) }}"
                    alt="{{ $client->name }}" />
                <div class="absolute z-40 bottom-2 right-2">
                    {{ ($this->editAction)(['type' => 'cover']) }}
                </div>
            @else
                <div>
                    {{ ($this->editAction)(['type' => 'cover']) }}
                </div>
            @endif
        </div>
    </div>

    <div class="flex items-center md:items-end justify-center md:justify-start w-full flex-col md:flex-row gap-3 relative z-10 sm:-mt-5 md:-mt-10">
        <div
            class="aspect-square rounded-full bg-gray-300 border border-white w-20 sm:w-24 md:w-28 lg:w-32 flex justify-center items-center relative">
            @if (isset($client->cover))
                <img class="w-full h-full object-cover rounded-full"
                    src="{{ asset('uploads/' . $client->profile_picture) }}" alt="{{ $client->name }}" />
                <div class="absolute z-10 bottom-2 right-2">
                    {{ ($this->editAction)(['type' => 'profile']) }}
                </div>
            @else
                <div>
                    {{ ($this->editAction)(['type' => 'profile']) }}
                </div>
            @endif
        </div>
        <div class="pb-3 text-center md:text-left">
            <h3 class="text-sm sm:text-basic md:text-lg font-bold text-gray-800">{{ $client->name }}</h3>
            <ul class="flex flex-wrap items-center gap-2">
                <li class="text-xs sm:text-sm md:text-basic">Member since {{ $client->created_at->format('d M Y') }}</li>
                <li class="text-xs sm:text-sm md:text-basic">|</li>
                <li class="text-xs sm:text-sm md:text-basic"><strong>{{ \App\Models\Quote::where('email', $client->email)->count() }}</strong> Quotes Made</li>
            </ul>
        </div>
    </div>

    <x-filament-actions::modals />
</div>
