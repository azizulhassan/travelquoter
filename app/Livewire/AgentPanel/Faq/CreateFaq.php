<?php

namespace App\Livewire\AgentPanel\Faq;

use App\Models\Faq;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms;
use Filament\Support\Enums\ActionSize;
use Illuminate\Support\Facades\Auth;

class CreateFaq extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $question;
    public $answer;

    public function createAction(): Action {
        return Action::make('create')->icon('heroicon-m-plus')->size(ActionSize::Large)->badge(function () {
            return Faq::where('agent_id', Auth::guard('agent')->user()->id)->count();
        })->label('Add FAQ')->action(function (array $arguments) {
            dd($arguments);
        })->form([
            Forms\Components\TextInput::make('question')->columnSpanFull()->required()->placeholder('Add a question'),
            Forms\Components\Textarea::make('answer')->rows(6)->columnSpanFull()->required()->placeholder('Add an answer'),
        ]);
    }

    public function render()
    {
        return view('livewire.agent-panel.faq.create-faq');
    }
}
