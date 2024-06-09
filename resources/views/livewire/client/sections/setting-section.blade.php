<div>
    <style>
        #setting-form .fi-fo-field-wrp div {
            display: flex;
            justify-content: space-between;
        }
    </style>
    <form id="setting-form" wire:submit="update">
        <div>
            {{ $this->form }}
        </div>
        <div class="ring-1 ring-gray-950/10 rounded-xl p-3 bg-white mt-4">
            <div class="flex flex-wrap justify-between items-center">
                <div>
                    <h3 class="text-sm font-bold">{{ __('Delete Account ?') }}</h3>
                    <p class="text-xs">{{ __('Do you want to deactivate your account?') }}</p>
                </div>
                <div>
                    <x-filament::button size="xs" wire:click="delete" color="danger" type="button" outlined>Delete</x-filament::button>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <x-filament::button size="lg" type="submit" color="primary">{{ __('Update') }}</x-filament::button>
        </div>
    </form>
</div>
