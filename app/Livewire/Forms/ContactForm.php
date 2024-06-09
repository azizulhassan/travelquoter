<?php

namespace App\Livewire\Forms;

use App\Models\Contact;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

class ContactForm extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $enquiry_type;
    public $full_name;
    public $mobile_number;
    public $email;
    public $message;

    public function form(Form $form): Form {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\Radio::make('enquiry_type')->label(__('Enquiry type'))->options([
                    'General Enquiry' => 'General Enquiry',
                    'Support' => 'Support'
                ])->columns(2)->required(),
                Forms\Components\TextInput::make('full_name')->label(__('Full name'))->maxLength(255)->required(),
                Forms\Components\TextInput::make('mobile_number')->label(__('Mobile number'))->tel()->required(),
                Forms\Components\TextInput::make('email')->label(__('Email'))->email()->maxLength(255)->required(),
                Forms\Components\Textarea::make('message')->label(__('Message'))->columnSpanFull(),
            ])->columns(2)
        ]);
    }

    public function save() {
        $data = [
            'enquiry_type' => $this->enquiry_type,
            'full_name' => $this->full_name,
            'mobile_number' => $this->mobile_number,
            'email' => $this->email,
            'message' => $this->message,
            'status' => false,
        ];

        Contact::create($data);

        Notification::make()->title(__('Enquiry submitted successfully. Our team will shortly contact you.'))->success()->send();

        $this->enquiry_type = NULL;
        $this->full_name = NULL;
        $this->mobile_number = NULL;
        $this->email = NULL;
        $this->message = NULL;
    }

    public function render()
    {
        return view('livewire.forms.contact-form');
    }
}
