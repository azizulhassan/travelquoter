<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AgencyResource\Pages;
use App\Filament\Admin\Resources\AgencyResource\RelationManagers;
use App\Models\Agency;
use App\Models\Agent;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class AgencyResource extends Resource
{
    protected static ?string $model = Agency::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Agent';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\Select::make('agent_id')->relationship('agent', 'email')->live()->required()->helperText(function ($state, Set $set) {
                        $agent = Agent::find($state);
                        if ($agent) {
                            return new HtmlString('
                                <ul class="rounded-lg border p-3 space-y-2 mt-3">
                                    <li>Name: ' . $agent->name . '</li>
                                    <li>Contact Number: ' . $agent->contact_number . '</li>
                                    <li>Email: ' . $agent->email . '</li>
                                </ul>
                            ');
                        }
                    }),
                ]),

                Forms\Components\Section::make()->schema([
                    Forms\Components\FileUpload::make('profile_picture')->avatar()->columnSpanFull()->maxSize(1024 * 1024 * 2),
                    Forms\Components\FileUpload::make('cover')->maxSize(1024 * 1024 * 2)->panelAspectRatio('3:1'),
                    Forms\Components\Textarea::make('business_description')->rows(7)->maxLength(65535),
                ])->columns(['sm' => 2]),

                Forms\Components\Section::make('')->schema([
                    Forms\Components\Select::make('country_id')->relationship('country', 'name')->live()->required(),
                    Forms\Components\Select::make('state_id')->options(function (Get $get) {
                        return State::where('country_id', $get('country_id'))->pluck('name')->toArray();
                    })->label('State')->required(),
                    Forms\Components\TextInput::make('agency_name')
                        ->maxLength(255)->required(),
                    Forms\Components\TextInput::make('mobile_number')
                        ->maxLength(255)->tel()->required(),
                    Forms\Components\TextInput::make('abn_acn')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('website_url')
                        ->maxLength(255)->url(),
                    Forms\Components\Toggle::make('do_you_operate_outside_australia'),
                    Forms\Components\Toggle::make('do_you_sale_through_your_website'),
                    Forms\Components\TextInput::make('street_address')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('postcode')
                        ->maxLength(255),
                    Forms\Components\TagsInput::make('services')
                        ->columnSpanFull()->placeholder(__('Add Service')),
                    Forms\Components\Toggle::make('status')->default(true)->required(),
                ])->columns(['sm' => 2])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('agent.email')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('country.name')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('state.name')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('agency_name')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('mobile_number')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('abn_acn')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('website_url')
                    ->searchable()->toggleable(),
                Tables\Columns\IconColumn::make('do_you_operate_outside_australia')
                    ->boolean()->toggleable(),
                Tables\Columns\IconColumn::make('do_you_sale_through_your_website')
                    ->boolean()->toggleable(),
                Tables\Columns\ImageColumn::make('profile_picture')
                    ->width(50)->height('auto')->toggleable(),
                Tables\Columns\ImageColumn::make('cover')
                    ->width(50)->height('auto')->toggleable(),
                Tables\Columns\TextColumn::make('street_address')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('postcode')
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
            'index' => Pages\ListAgencies::route('/'),
            'create' => Pages\CreateAgency::route('/create'),
            'view' => Pages\ViewAgency::route('/{record}'),
            'edit' => Pages\EditAgency::route('/{record}/edit'),
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
