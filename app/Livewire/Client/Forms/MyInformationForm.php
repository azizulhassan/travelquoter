<?php

namespace App\Livewire\Client\Forms;

use App\Models\Country;
use App\Models\State;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MyInformationForm extends Component implements HasForms
{
    use InteractsWithForms;

    public $name;
    public $extra_fields;
    public $contact_number;
    public $email;
    public $password;
    public $country_id;
    public $state_id;
    public $street_address;
    public $postcode;

    public $client;

    public function mount() {
        $this->client = Auth::guard('client')->user();

        $this->form->fill($this->client->toArray());
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->maxLength(255)->label(__('Name')),
            Forms\Components\TextInput::make('extra_fields.profession')
                ->maxLength(255)->label(__('Profession')),
            Forms\Components\TextInput::make('contact_number')
                ->maxLength(255)->label(__('Contact number')),
            Forms\Components\TextInput::make('email')->label(__('Email'))
                ->email()->unique(ignoreRecord: true)->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('password')->label(__('Password'))
                ->password()->minLength(8)
                ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                ->dehydrated(fn ($state) => filled($state)),
            Forms\Components\Select::make('country_id')->options(Country::where('status', true)->pluck('name', 'id'))->live()->searchable()->preload()->label(__('Country')),
            Forms\Components\Select::make('state_id')->options(function (Get $get) {
                return State::where('country_id', $get('country_id'))->pluck('name', 'id');
            })->label(__('State'))->searchable()->preload(),
            Forms\Components\TextInput::make('street_address')->label(__('Street address'))
                ->maxLength(255),
            Forms\Components\TextInput::make('postcode')->label(__('Postcode'))
                ->maxLength(255),
        ])->columns([
            'default' => 2
        ]);
    }

    public function update() {
        $data = $this->form->getState();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $this->client->update($this->form->getState());
        Notification::make()->title('Updated successfully')->success()->send();
    }

    public function render()
    {
        return view('livewire.client.forms.my-information-form');
    }
}
