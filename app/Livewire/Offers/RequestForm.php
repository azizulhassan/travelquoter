<?php

namespace App\Livewire\Offers;

use App\Models\Quote;
use App\Models\QuoteOffer;
use Livewire\Component;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Forms\Form;
use Marvinosswald\FilamentInputSelectAffix\TextInputSelectAffix;

class RequestForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $offer;

    public $name;
    public $email;
    public $receive_quote_via = [];
    public $mobile_number;
    public $budget_value;
    public $budget_currency;
    public $suitable_time = [];
    public $comment;

    public function mount()
    {
        $this->budget_currency = 'USD';
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'receive_quote_via' => 'required',
            'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'budget_value' => 'required|numeric',
            'budget_currency' => 'required',
            'suitable_time' => 'required'
        ]);

        $receive_quote_via_call = false;
        $receive_quote_via_sms = false;
        $receive_quote_via_email = false;

        if (in_array("call", $this->receive_quote_via)) {
            $receive_quote_via_call = true;
        }

        if (in_array("sms", $this->receive_quote_via)) {
            $receive_quote_via_sms = true;
        }

        if (in_array("email", $this->receive_quote_via)) {
            $receive_quote_via_email = true;
        }

        $quote = Quote::create([
            'full_name' => $this->name,
            'mobile_number' => $this->mobile_number,
            'email' => $this->email,
            'budget' => $this->budget_value . ' ' . $this->budget_currency,
            'receive_quote_via_call' => $receive_quote_via_call,
            'receive_quote_via_sms' => $receive_quote_via_sms,
            'receive_quote_via_email' => $receive_quote_via_email,
            'suitable_time' => $this->suitable_time,
            'comment' => $this->comment,
            'status' => true,
        ]);

        QuoteOffer::create([
            'quote_id' => $quote->id,
            'offer_id' => $this->offer->id,
        ]);

        Notification::make()->title('Quote sent sucessfully. We will be contacting you soon.')->success()->send();

        $this->name = NULL;
        $this->email = NULL;
        $this->receive_quote_via = [];
        $this->mobile_number = NULL;
        $this->budget_value = NULL;
        $this->budget_currency = NULL;
        $this->suitable_time = [];
        $this->comment = NULL;
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('')->schema([
                Forms\Components\TextInput::make('name')->label(__('Full Name'))->maxLength(255)->required(),
                Forms\Components\TextInput::make('email')->label(__('Email'))->prefixIcon('heroicon-o-envelope')->email()->maxLength(255)->required(),
                Forms\Components\CheckboxList::make('receive_quote_via')->label(__('How would you like to receive your quote?'))->options([
                    "call" => __("Call"),
                    "sms" => __("SMS"),
                    "email" => __("Email")
                ])->columns(5)->required(),
                Forms\Components\TextInput::make('mobile_number')->prefixIcon('heroicon-o-phone')->label(__('Mobile Number'))->tel()->maxLength(20)->required(),
                TextInputSelectAffix::make('budget_value')->label(__('Budget'))->numeric()->select(fn () => Forms\Components\Select::make('budget_currency')->extraAttributes(['class' => 'w-[30px]'])->options([
                    'usd' => __('USD'),
                    'eur' => __('EUR'),
                    'chf' => __('CHF'),
                    'jpy' => __('JPY'),
                    'cny' => __('CNY'),
                    'gbp' => __('GBP'),
                    'sek' => __('SEK'),
                    'aud' => __('AUD'),
                    'nzd' => __('NZD'),
                ])->placeholder(__('Choose'))->default('usd')->required())->required(),
                Forms\Components\CheckboxList::make('suitable_time')->label(__('What is the suitable time?'))->options([
                    "Working hours (9-5 PM)" => __("Working hours (9-5 PM)"),
                    "After hours" => __("After hours"),
                    "Anytime" => __("Anytime")
                ])->columns(3)->required(),
                Forms\Components\Textarea::make('comment')->label(__('Comment'))->rows(6)->columnSpanFull(),
            ])->columns(2)
        ]);
    }

    public function render()
    {
        return view('livewire.offers.request-form');
    }
}
