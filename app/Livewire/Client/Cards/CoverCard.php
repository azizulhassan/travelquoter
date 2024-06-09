<?php

namespace App\Livewire\Client\Cards;

use App\Models\Client;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class CoverCard extends Component implements HasForms, HasActions
{
    use InteractsWithActions, InteractsWithForms;

    public $client;

    public function mount()
    {
        $this->client = Auth::guard('client')->user();
    }

    public function editAction(): Action
    {
        return Action::make('edit')->icon('heroicon-o-photo')->size('xs')->color('gray')->label(__('Edit'))->action(function (array $data) {
            $db_client = Client::find($this->client->id);
            $db_client->update($data);
            Notification::make()->title('Cover Image Updated.')->success()->send();
        })->form(function (array $arguments) {
            if ($arguments['type'] == 'profile') {
                return [
                    Forms\Components\FileUpload::make('profile_picture')->avatar()->maxSize(1024 * 1024 * 2)->required()->label('')
                ];
            } else {
                return [
                    Forms\Components\FileUpload::make('cover')->maxSize(1024 * 1024 * 2)->required()->label('')
                ];
            }
        });
    }

    public function render()
    {
        return view('livewire.client.cards.cover-card');
    }
}
