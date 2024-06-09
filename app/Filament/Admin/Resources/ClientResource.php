<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ClientResource\Pages;
use App\Filament\Admin\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use App\Models\State;
use App\Models\Country;
use Filament\Forms\Get;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'More';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')->schema([
                    Forms\Components\FileUpload::make('cover')->columnSpanFull()->inlineLabel(),
                    Forms\Components\FileUpload::make('profile_picture')
                        ->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('profession')
                        ->maxLength(255)->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('name')
                        ->maxLength(255)->required()->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('contact_number')->tel()->columnSpanFull()->inlineLabel()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('password')
                        ->password()->minLength(8)
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->dehydrated(fn ($state) => filled($state))->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('email')
                        ->email()->unique(ignoreRecord: true)->required()
                        ->maxLength(255)->columnSpanFull()->inlineLabel(),
                    Forms\Components\Select::make('country_id')
                        ->relationship('country', 'name')->live()->searchable()->preload()->columnSpanFull()->inlineLabel(),
                    Forms\Components\Select::make('state_id')->options(function (Get $get) {
                        return State::where('country_id', $get('country_id'))->pluck('name', 'name');
                    })->columnSpanFull()->inlineLabel()->label('State')->searchable()->preload(),
                    Forms\Components\TextInput::make('street_address')
                        ->maxLength(255)->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('postcode')
                        ->maxLength(255)->columnSpanFull()->inlineLabel(),
                    // Forms\Components\DateTimePicker::make('email_verified_at'),
                    Forms\Components\Toggle::make('status')->default(true)->columnSpanFull()->inlineLabel(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country.name')
                    ->toggleable()->searchable(),
                Tables\Columns\TextColumn::make('state.name')
                    ->toggleable()->searchable(),
                Tables\Columns\ImageColumn::make('cover')->width(80)->height('auto')
                    ->toggleable(),
                Tables\Columns\ImageColumn::make('profile_picture')->width(80)->height('auto')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('profession')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('contact_number')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('street_address')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('postcode')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\ToggleColumn::make('status')->toggleable(),
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'view' => Pages\ViewClient::route('/{record}'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
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
