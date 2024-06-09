<?php

namespace App\Livewire\Cards;

use Carbon\Carbon;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Illuminate\Support\HtmlString;

class DateCalculatorCard extends Component implements HasForms
{
    use InteractsWithForms;

    public $departure_date;
    public $return_date;

    public function clear() {
        $this->departure_date = NULL;
        $this->return_date = NULL;
    }

    public function form(Form $form):Form {
        return $form->schema([
            Forms\Components\DatePicker::make('departure_date')->live()->label(__('Departure Date'))->native(false)->prefixIcon('heroicon-o-calendar-days'),
            Forms\Components\DatePicker::make('return_date')->live()->label(__('Return Date'))->native(false)->prefixIcon('heroicon-o-calendar-days'),
            Forms\Components\Placeholder::make('')->content(function(Get $get) {
                $departure_date = $get('departure_date');
                $return_date = $get('return_date');

                $calcualted_day = 0;

                if ( $departure_date && $return_date ) {
                    $calcualted_day = Carbon::parse($departure_date)->diffInDays(Carbon::parse($return_date));
                } 

                return new HtmlString('
                    <div class="border shadow-sm rounded-lg bg-white p-4 flex flex-col items-center justify-center text-center">
                        <h3 class="font-bold text-zinc-800">'.__('Trip Days').'</h3>
                        <h4 class="text-xl font-medium">'. $calcualted_day .' '.__('Days').'</h4>
                    </div>
                ');
            })
        ]);
    }

    public function render()
    {
        return view('livewire.cards.date-calculator-card');
    }
}
