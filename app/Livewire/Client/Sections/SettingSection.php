<?php

namespace App\Livewire\Client\Sections;

use App\Models\Client;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\FormsComponent;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class SettingSection extends Component implements HasForms
{
    use InteractsWithForms;

    public $client;
    public ?array $data;

    public function mount() {
        $this->client = Auth::guard('client')->user();

        $this->form->fill($this->client->extra_fields);
    }

    public function form(Form $form):Form {
        return $form->schema([
            Forms\Components\Toggle::make('email_notification')->label(__('Email notification'))->columnSpanFull()->inlineLabel(),
            Forms\Components\Toggle::make('inbox_messages_notification')->label(__('Inbox messages notification'))->columnSpanFull()->inlineLabel(),
            Forms\Components\Toggle::make('quotes_messages_notification')->label(__('Quotes messages notification'))->columnSpanFull()->inlineLabel(),
            Forms\Components\Toggle::make('quotes_updates_notification')->label(__('Quotes updates notification'))->columnSpanFull()->inlineLabel(),
            Forms\Components\Toggle::make('account_notification')->label(__('Account notification'))->columnSpanFull()->inlineLabel(),
        ])->columns(['default' => 2])->statePath('data');
    }

    public function update() {
        $client = Client::find($this->client->id);
        $client->extra_fields = $this->form->getState();
        $client->save();

        Notification::make()->title('Setting updated.')->success()->send();
    }

    public function render()
    {
        return view('livewire.client.sections.setting-section');
    }
}
