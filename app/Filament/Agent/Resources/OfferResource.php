<?php

namespace App\Filament\Agent\Resources;

use App\Filament\Agent\Resources\OfferResource\Pages;
use App\Filament\Agent\Resources\OfferResource\RelationManagers;
use App\Models\Offer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Agent\'s Offers';

    protected static ?int $navigationSort = null;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('agent_id')->default(Auth::guard('agent')->user()->id),
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make(__('BASIC INFORMATION'))->description(__('Enter the basic info about your offer'))->schema([
                        Forms\Components\TextInput::make('title')->label(__('Offer Title'))->required()->maxLength(255)->placeholder(__('Enter title')),
                        Forms\Components\TextInput::make('extra_field.destination')->label(__('Destination'))->required()->maxLength(255)->placeholder(__('Enter destination')),
                        Forms\Components\TagsInput::make('extra_field.package_include')->label(__('What does your package include?'))->required()->placeholder(__('')),
                        Forms\Components\Select::make('category')->label(__('Category'))->options([
                            'Daily Deals' => 'Daily Deals',
                            'Top Offers' => 'Top Offers',
                            'Recommended' => 'Recommended',
                            'Others' => 'Others'
                        ])->required()->native(false),

                        Forms\Components\TextInput::make('previous_price')->label(__('Previous Price / Person'))
                            ->numeric()->prefix(__('$')),
                        Forms\Components\TextInput::make('current_price')->label(__('Current Price / Person'))
                            ->numeric()->prefix(__('$'))->required(),

                        Forms\Components\Fieldset::make('Traveling Date')->schema([
                            Forms\Components\DatePicker::make('extra_field.traveling_from')->label('')->placeholder(__('Traveling From'))->native(false)->suffixIcon('heroicon-o-calendar'),
                            Forms\Components\DatePicker::make('extra_field.traveling_to')->label('')->placeholder(__('Traveling To'))->native(false)->suffixIcon('heroicon-o-calendar'),
                        ])->columns(['sm' => 2]),

                        Forms\Components\TextInput::make('person')->numeric()->label(__('Number of Persons'))->placeholder(__('Enter'))->required(),
                    ])->columns(['sm' => 2]),

                    Forms\Components\Wizard\Step::make(__('OTHER INFORMATION'))->description(__('Enter the other info about your offer'))->schema([
                        Forms\Components\FileUpload::make('thumbnail')->label(__('Upload Image'))->panelAspectRatio('2:2'),
                        Forms\Components\RichEditor::make('description')->label(__('Offer Description'))->columnSpanFull()->required(),
                        Forms\Components\Fieldset::make('Offer Date')->schema([
                            Forms\Components\DatePicker::make('valid_from')->label('')->placeholder(__('Start Date'))->native(false)->suffixIcon('heroicon-o-calendar'),
                            Forms\Components\DatePicker::make('valid_till')->label('')->placeholder(__('End Date'))->native(false)->suffixIcon('heroicon-o-calendar'),
                        ])->columns(['sm' => 2]),
                        Forms\Components\TagsInput::make('extra_field.famous_places')->label(__('Famous Places'))->required()->placeholder(__('Add Famous Places'))->columnSpan(['sm' => 2]),
                        Forms\Components\TextInput::make('location')->label(__('Offer Area'))->columnSpan(['sm' => 2])->required(),
                        Forms\Components\Toggle::make('status')->default(false)->columnSpan(['sm' => 2]),
                    ])->columns(['sm' => 4]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('previous_price')
                    ->numeric()
                    ->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('current_price')
                    ->numeric()
                    ->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('category')->toggleable()->searchable(),
                Tables\Columns\TextColumn::make('valid_from')
                    ->date()
                    ->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('valid_till')
                    ->date()
                    ->sortable()->toggleable(),
                Tables\Columns\ImageColumn::make('thumbnail')->width(80)->height('auto')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable()->toggleable(),
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
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'view' => Pages\ViewOffer::route('/{record}'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
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
