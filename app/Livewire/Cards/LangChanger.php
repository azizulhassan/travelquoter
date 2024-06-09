<?php

namespace App\Livewire\Cards;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;

class LangChanger extends Component implements HasForms
{
    use InteractsWithForms;

    public $language;

    public function mount() {
        if (!session()->has('current_local')) {
            session(['current_local' => 'en']);
        }
        $this->language = session()->get('current_local');
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('language')->label('')->lazy()->options([
                'en' => 'EN',
                'np' => 'NP',
                'es' => 'ES'
            ])->extraAlpineAttributes(['class' => 'p-1'])->native(false)->placeholder('en'),
        ]);
    }

    public function updatedLanguage()
    {
        if ($this->language) {
            session(['current_local' => $this->language]);
            app()->setLocale($this->language);
            return $this->redirect('/', false);
        }
    }

    public function render()
    {
        return view('livewire.cards.lang-changer');
    }
}
