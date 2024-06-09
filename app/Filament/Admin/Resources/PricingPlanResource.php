<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PricingPlanResource\Pages;
use App\Filament\Admin\Resources\PricingPlanResource\RelationManagers;
use App\Models\PricingPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PricingPlanResource extends Resource
{
    protected static ?string $model = PricingPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'More';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::user()->id),
                Forms\Components\Section::make('')->schema([
                    Forms\Components\TextInput::make('title')
                        ->maxLength(255)->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('order')->numeric()->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\Select::make('pricing_type')->options([
                        'month' => 'Month',
                        'annual' => 'Annual'
                    ])->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\FileUpload::make('icon')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('price')->numeric()
                        ->maxLength(255)->columnSpanFull()->inlineLabel()->required()->prefix('$')->required(),
                    Forms\Components\TextInput::make('short_description')
                        ->maxLength(255)->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TagsInput::make('perks')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\Toggle::make('status')->columnSpanFull()->inlineLabel()->default(true),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()->toggleable(),
                Tables\Columns\TextInputColumn::make('order')->rules(['numeric'])->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('pricing_type')
                    ->searchable()->toggleable(),
                Tables\Columns\ImageColumn::make('icon')->width(50)->height('auto')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('price')
                    ->toggleable()->sortable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('id', 'DESC')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPricingPlans::route('/'),
            'create' => Pages\CreatePricingPlan::route('/create'),
            'view' => Pages\ViewPricingPlan::route('/{record}'),
            'edit' => Pages\EditPricingPlan::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
