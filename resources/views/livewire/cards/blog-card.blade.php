<div class="w-full border rounded-lg shadow">
    <div class="relative">
        <img class="rounded-tl-lg rounded-tr-lg aspect-[16/9] w-full bg-gray-50"
            src="{{ asset('/uploads/' . $item->thumbnail) }}" alt="Travel Partner Profile Cover" />
        {{-- <button class="absolute top-2 left-2 text-white transition-all duration-200 hover:text-[#E03F3F]">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path
                    d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
            </svg>
        </button> --}}
    </div>
    <div class="p-3">
        <a href="{{ route('blogs.single', ['slug' => $item->slug.'-'.$item->id]) }}"
            class="mb-3 font-medium text-sm line-clamp-1 hover:underline">{{ __($item->title) }}</a>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-x-1">
                <img src="{{ asset('img/icons/calender.svg') }}" alt="calender icon" />
                <span class="text-xs line-clamp-1">{{ __(date_format($item->created_at, 'd M Y')) }}</span>
            </div>
            <div class="flex items-center gap-x-1">
                <img src="{{ asset('img/icons/person.svg') }}" alt="person icon">
                <span class="text-xs line-clamp-1">{{ __($item->written_by) }}</span>
            </div>
        </div>
        <p class="text-sm mt-3 line-clamp-2">{{ __($item->short_description) }}</p>
        @if ($item->newsCategories)
            <div class="mt-3">
                @foreach ($item->newsCategories as $category)
                    <span class="text-xs px-3 py-1 rounded-full bg-gray-200">{{ __($category->name) }}</span>
                @endforeach
            </div>
        @endif
    </div>
</div>
