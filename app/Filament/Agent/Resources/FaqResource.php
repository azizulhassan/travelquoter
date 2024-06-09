<?php

namespace App\Filament\Agent\Resources;

use App\Filament\Agent\Resources\FaqResource\Pages;
use App\Filament\Agent\Resources\FaqResource\RelationManagers;
use App\Models\Faq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Agent\'s FAQ';

    protected static ?int $navigationSort = null;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('agent_id')->default(Auth::guard('agent')->user()->id),
                Forms\Components\TextInput::make('question')->label(__('Question'))->required()->maxLength(255)->columnSpanFull(),
                Forms\Components\RichEditor::make('answer')->label(__('Answer'))
                    ->maxLength(65535)
                    ->columnSpanFull()->required(),
                Forms\Components\Toggle::make('status')->label(__('Status'))->default(true),
            ])->columns(['sm' => 2]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->searchable(),
                Tables\Columns\Layout\Panel::make([
                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\TextColumn::make('answer')->html()
                    ])
                ])->collapsed()
            ])->defaultSort('id', 'DESC')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFaqs::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('agent_id', Auth::guard('agent')->user()->id)
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
