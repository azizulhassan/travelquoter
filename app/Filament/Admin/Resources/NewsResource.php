<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\NewsResource\Pages;
use App\Filament\Admin\Resources\NewsResource\RelationManagers;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil';

    protected static ?string $navigationGroup = 'News';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')->default(Auth::user()->id),
                Forms\Components\Section::make('')->schema([
                    Forms\Components\Select::make('agent_id')->relationship('agent', 'email')->columnSpanFull()->inlineLabel(),
                    Forms\Components\Select::make('client_id')->relationship('client', 'email')->columnSpanFull()->inlineLabel(),

                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                            if ($operation !== 'create') {
                                return;
                            }
                            $set('slug', Str::slug($state));
                        })->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('slug')
                        ->disabled()
                        ->dehydrated()
                        ->required()
                        ->unique(News::class, 'slug', ignoreRecord: true)->columnSpanFull()->inlineLabel(),

                    Forms\Components\Select::make('newsCategories')->multiple()->relationship('newsCategories', 'name')->searchable()->preload()->columnSpanFull()->inlineLabel(),

                    Forms\Components\RichEditor::make('description')
                        ->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\FileUpload::make('thumbnail')->columnSpanFull()->inlineLabel(),
                    Forms\Components\FileUpload::make('featured_video')->columnSpanFull()->inlineLabel(),
                    Forms\Components\Toggle::make('is_featured')->columnSpanFull()->inlineLabel(),
                    Forms\Components\Toggle::make('status')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('written_by')
                        ->maxLength(255)->columnSpanFull()->inlineLabel(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('agent.email')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('client.email')
                    ->toggleable()->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()->toggleable(),
                Tables\Columns\ImageColumn::make('thumbnail')->width(50)->height('auto')->toggleable(),
                Tables\Columns\ToggleColumn::make('is_featured')->toggleable(),
                Tables\Columns\ToggleColumn::make('status')->toggleable(),
                Tables\Columns\TextColumn::make('written_by')->toggleable()
                    ->searchable(),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'view' => Pages\ViewNews::route('/{record}'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
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
