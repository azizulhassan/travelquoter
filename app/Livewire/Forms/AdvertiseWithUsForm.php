<?php

namespace App\Livewire\Forms;

use App\Models\AdvertiseWithUs;
use Livewire\Component;

use Filament\Forms\Form;
use Filament\Forms;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

class AdvertiseWithUsForm extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $full_name;
    public $mobile_number;
    public $email;
    public $company_name;
    public $message;

    public function form(Form $form): Form {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\TextInput::make('full_name')->label(__('Full Name'))->maxLength(255)->required(),
                Forms\Components\TextInput::make('mobile_number')->label(__('Mobile Number'))->tel()->required(),
                Forms\Components\TextInput::make('email')->label(__('Email'))->email()->maxLength(255)->required(),
                Forms\Components\TextInput::make('company_name')->label(__('Company Name'))->maxLength(255)->required(),
                Forms\Components\Textarea::make('message')->label(__('Message'))->columnSpanFull(),
            ])->columns(2)
        ]);
    }

    public function save() {
        $data = [
            'name' => $this->full_name,
            'mobile_number' => $this->mobile_number,
            'email' => $this->email,
            'company_name' => $this->company_name,
            'message' => $this->message,
            'status' => false,
        ];

        AdvertiseWithUs::create($data);

        Notification::make()->title(__('Enquiry submitted successfully. Our team will shortly contact you.'))->success()->send();

        $this->full_name = NULL;
        $this->mobile_number = NULL;
        $this->email = NULL;
        $this->company_name = NULL;
        $this->message = NULL;
    }

    public function render()
    {
        return view('livewire.forms.advertise-with-us-form');
    }
}
