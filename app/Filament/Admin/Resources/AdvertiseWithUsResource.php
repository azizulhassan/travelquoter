<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AdvertiseWithUsResource\Pages;
use App\Filament\Admin\Resources\AdvertiseWithUsResource\RelationManagers;
use App\Models\AdvertiseWithUs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AdvertiseWithUsResource extends Resource
{
    protected static ?string $model = AdvertiseWithUs::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'More';

    protected static ?string $navigationLabel = 'Advertise with us';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')->schema([
                    Forms\Components\Hidden::make('user_id')
                        ->default(Auth::user()->id),
                    Forms\Components\TextInput::make('name')
                        ->maxLength(255)->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('mobile_number')
                        ->maxLength(255)->tel()->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->maxLength(255)->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('company_name')
                        ->maxLength(255)->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\Textarea::make('message')
                        ->maxLength(65535)
                        ->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\Toggle::make('status')->columnSpanFull()->inlineLabel()->default(true),
                    Forms\Components\Textarea::make('reason')
                        ->maxLength(65535)
                        ->columnSpanFull()->inlineLabel(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('mobile_number')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('company_name')
                    ->searchable()->toggleable(),
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
            'index' => Pages\ListAdvertiseWithUs::route('/'),
            'create' => Pages\CreateAdvertiseWithUs::route('/create'),
            'view' => Pages\ViewAdvertiseWithUs::route('/{record}'),
            'edit' => Pages\EditAdvertiseWithUs::route('/{record}/edit'),
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
