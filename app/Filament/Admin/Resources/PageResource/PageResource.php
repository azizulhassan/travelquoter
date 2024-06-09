<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PageResource\Pages;
use App\Filament\Admin\Resources\PageResource\RelationManagers;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

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
                    Forms\Components\Hidden::make('user_id')->default(Auth::user()->id),
                    Forms\Components\TextInput::make('title')
                        ->maxLength(255)->disabled()->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('subtitle')
                        ->maxLength(255)->columnSpanFull()->inlineLabel(),
                ]),
                // Forms\Components\Toggle::make('status')->default(true)->columnSpanFull()->inlineLabel(),
                Forms\Components\Section::make('seo')->schema([
                    Forms\Components\TextInput::make('meta_data.meta_title')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('meta_data.meta_description')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TagsInput::make('meta_data.meta_keyword')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\FileUpload::make('meta_data.meta_thumbnail')->columnSpanFull()->inlineLabel()->required(),
                ])->columnSpanFull()->collapsible(),
                Forms\Components\Section::make('content')->schema(static::differentPage('About Us'))->hidden(function (Get $get) {
                    if ($get('title') == 'About Us') {
                        return false;
                    }
                    return true;
                }),
                Forms\Components\Section::make('content')->schema(static::differentPage('Home'))->hidden(function (Get $get) {
                    if ($get('title') == 'Home') {
                        return false;
                    }
                    return true;
                }),
                Forms\Components\Section::make('content')->schema(static::differentPage('Privacy Policy'))->hidden(function (Get $get) {
                    if ($get('title') == 'Privacy Policy') {
                        return false;
                    }
                    return true;
                }),
                Forms\Components\Section::make('content')->schema(static::differentPage('Terms And Conditions'))->hidden(function (Get $get) {
                    if ($get('title') == 'Terms And Conditions') {
                        return false;
                    }
                    return true;
                }),
                Forms\Components\Section::make('content')->schema(static::differentPage('Contact Us'))->hidden(function (Get $get) {
                    if ($get('title') == 'Contact Us') {
                        return false;
                    }
                    return true;
                }),
                Forms\Components\Section::make('content')->schema(static::differentPage('Advertise with us'))->hidden(function (Get $get) {
                    if ($get('title') == 'Advertise with us') {
                        return false;
                    }
                    return true;
                }),
                Forms\Components\Section::make('content')->schema(static::differentPage('Travel Agent Membership'))->hidden(function (Get $get) {
                    if ($get('title') == 'Travel Agent Membership') {
                        return false;
                    }
                    return true;
                }),
                Forms\Components\Section::make('content')->schema(static::differentPage('Become a TravelQuoter Partner'))->hidden(function (Get $get) {
                    if ($get('title') == 'Become a TravelQuoter Partner') {
                        return false;
                    }
                    return true;
                }),

                Forms\Components\Section::make('content')->schema(static::differentPage('Faq'))->hidden(function (Get $get) {
                    if ($get('title') == 'Faq') {
                        return false;
                    }
                    return true;
                }),

                Forms\Components\Section::make('content')->schema(static::differentPage('Register'))->hidden(function (Get $get) {
                    if ($get('title') == 'Register') {
                        return false;
                    }
                    return true;
                }),

                Forms\Components\Section::make('content')->schema(static::differentPage('Login'))->hidden(function (Get $get) {
                    if ($get('title') == 'Login') {
                        return false;
                    }
                    return true;
                }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
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

    public static function differentPage($page): array
    {
        if ($page == 'About Us') {
            return [
                Forms\Components\TextInput::make('page_content.thumbnail')->columnSpanFull()->inlineLabel(),
                Forms\Components\TextInput::make('page_content.video')->url()->columnSpanFull()->inlineLabel(),
                Forms\Components\RichEditor::make('page_content.description')->columnSpanFull()->inlineLabel(),
                Forms\Components\Section::make('Why us Section')->schema([
                    Forms\Components\TextInput::make('page_content.why_us_section.title')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('page_content.why_us_section.subtitle')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\Repeater::make('page_content.why_us_section.content')->schema([
                        Forms\Components\FileUpload::make('icon'),
                        Forms\Components\TextInput::make('title')->maxLength(255),
                        Forms\Components\Textarea::make('description'),
                    ])
                ])->columnSpanFull()->inlineLabel()->collapsible()->collapsed(),
            ];
        } elseif ($page == 'Home') {
            return [
                Forms\Components\Section::make('Hero Section')->schema([
                    Forms\Components\TextInput::make('page_content.hero_section.title')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.hero_section.subtitle')->columnSpanFull()->inlineLabel(),
                    Forms\Components\FileUpload::make('page_content.hero_section.background')->columnSpanFull()->inlineLabel(),
                ])->columnSpanFull()->collapsible()->collapsed(),

                Forms\Components\Section::make('Advertisement')->schema([
                    Forms\Components\FileUpload::make('page_content.advertisement_1.banner')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.advertisement_1.redirect-url')->url()->columnSpanFull()->inlineLabel(),
                ])->columnSpanFull()->collapsible()->collapsed(),


                Forms\Components\Section::make('Offer Section')->schema([
                    Forms\Components\TextInput::make('page_content.offer_section.title')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.offer_section.subtitle')->columnSpanFull()->inlineLabel(),
                    Forms\Components\Placeholder::make('')->columnSpanFull()->dehydrated(false)->content('Here slider with offer card will be displayed dynamically.'),
                ])->columnSpanFull()->collapsible()->collapsed(),


                Forms\Components\Section::make('Advertisement')->schema([
                    Forms\Components\FileUpload::make('page_content.advertisement_2.banner')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.advertisement_2.redirect-url')->url()->columnSpanFull()->inlineLabel(),
                ])->columnSpanFull()->collapsible()->collapsed(),


                Forms\Components\Section::make('App Promotion Section')->schema([
                    Forms\Components\TextInput::make('page_content.app_promotion_section.title')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.app_promotion_section.subtitle')->columnSpanFull()->inlineLabel(),
                    Forms\Components\Textarea::make('page_content.app_promotion_section.description')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.app_promotion_section.android_playstore_link')->url()->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.app_promotion_section.apple_playstore_link')->url()->columnSpanFull()->inlineLabel(),
                    Forms\Components\FileUpload::make('page_content.app_promotion_section.app_preview_1')->columnSpanFull()->inlineLabel(),
                    Forms\Components\FileUpload::make('page_content.app_promotion_section.app_preview_2')->columnSpanFull()->inlineLabel(),
                    Forms\Components\Placeholder::make('')->columnSpanFull()->dehydrated(false)->content('Here slider with offer card will be displayed dynamically.'),
                ])->columnSpanFull()->collapsible()->collapsed(),

                Forms\Components\Section::make('Advertisement')->schema([
                    Forms\Components\FileUpload::make('page_content.advertisement_3.banner')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.advertisement_3.redirect-url')->url()->columnSpanFull()->inlineLabel(),
                ])->columnSpanFull()->collapsible()->collapsed(),


                Forms\Components\Section::make('G-trip Section')->schema([
                    Forms\Components\TextInput::make('page_content.gtrip_section.title')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.gtrip_section.subtitle')->columnSpanFull()->inlineLabel(),
                    Forms\Components\Textarea::make('page_content.gtrip_section.description')->columnSpanFull()->inlineLabel(),
                    Forms\Components\FileUpload::make('page_content.gtrip_section.thumbnail')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.gtrip_section.cta_name')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.gtrip_section.cta_link')->columnSpanFull()->inlineLabel()->url(),
                ])->columnSpanFull()->collapsible()->collapsed(),

                Forms\Components\Section::make('Advertisement')->schema([
                    Forms\Components\FileUpload::make('page_content.advertisement_4.banner')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.advertisement_4.redirect-url')->url()->columnSpanFull()->inlineLabel(),
                ])->columnSpanFull()->collapsible()->collapsed(),


                Forms\Components\Section::make('Travel Agent Section')->schema([
                    Forms\Components\TextInput::make('page_content.travel_agent_section.title')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.travel_agent_section.subtitle')->columnSpanFull()->inlineLabel(),
                    Forms\Components\Placeholder::make('')->columnSpanFull()->dehydrated(false)->content('Here slider with travel agents card will be displayed dynamically.'),
                ])->columnSpanFull()->collapsible()->collapsed(),

                Forms\Components\Section::make('Advertisement')->schema([
                    Forms\Components\FileUpload::make('page_content.advertisement_5.banner')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.advertisement_5.redirect-url')->url()->columnSpanFull()->inlineLabel(),
                ])->columnSpanFull()->collapsible()->collapsed(),

                Forms\Components\Section::make('Become a Partner Section')->schema([
                    Forms\Components\TextInput::make('page_content.become_a_partner_section.title')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.become_a_partner_section.subtitle')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.become_a_partner_section.cta_name_1')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.become_a_partner_section.cta_link_1')->url()->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.become_a_partner_section.cta_name_2')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.become_a_partner_section.cta_link_2')->url()->columnSpanFull()->inlineLabel(),
                ])->columnSpanFull()->collapsible()->collapsed(),

                Forms\Components\Section::make('Advertisement')->schema([
                    Forms\Components\FileUpload::make('page_content.advertisement_6.banner')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.advertisement_6.redirect-url')->url()->columnSpanFull()->inlineLabel(),
                ])->columnSpanFull()->collapsible()->collapsed(),

                Forms\Components\Section::make('How does it work Section')->schema([
                    Forms\Components\TextInput::make('page_content.how_does_it_work_section.title')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('page_content.how_does_it_work_section.subtitle')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\FileUpload::make('page_content.how_does_it_work_section.thumbnail')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('page_content.how_does_it_work_section.yt_video_link')->columnSpanFull()->inlineLabel()->url()->required(),
                    Forms\Components\Repeater::make('page_content.how_does_it_work_section.content')->schema([
                        Forms\Components\FileUpload::make('icon'),
                        Forms\Components\TextInput::make('title')->maxLength(255),
                        Forms\Components\Textarea::make('description'),
                    ])
                ])->columnSpanFull()->collapsible()->collapsed(),


                Forms\Components\Section::make('Advertisement')->schema([
                    Forms\Components\FileUpload::make('page_content.advertisement_7.banner')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.advertisement_7.redirect-url')->url()->columnSpanFull()->inlineLabel(),
                ])->columnSpanFull()->collapsible()->collapsed(),


                Forms\Components\Section::make('Why us Section')->schema([
                    Forms\Components\TextInput::make('page_content.why_us_section.title')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('page_content.why_us_section.subtitle')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\Repeater::make('page_content.why_us_section.content')->schema([
                        Forms\Components\FileUpload::make('icon'),
                        Forms\Components\TextInput::make('title')->maxLength(255),
                        Forms\Components\Textarea::make('description'),
                    ])
                ])->columnSpanFull()->collapsible()->collapsed(),

                Forms\Components\Section::make('Advertisement')->schema([
                    Forms\Components\FileUpload::make('page_content.advertisement_8.banner')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.advertisement_8.redirect-url')->url()->columnSpanFull()->inlineLabel(),
                ])->columnSpanFull()->collapsible()->collapsed(),



                Forms\Components\Section::make('Famous Place Section')->schema([
                    Forms\Components\TextInput::make('page_content.famous_place_section.title')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('page_content.famous_place_section.subtitle')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\Repeater::make('page_content.why_us_section.content')->schema([
                        Forms\Components\FileUpload::make('thumbnail'),
                        Forms\Components\TextInput::make('name')->maxLength(255),
                        Forms\Components\TextInput::make('redirect_url')->url(),
                    ])
                ])->columnSpanFull()->collapsible()->collapsed(),

                Forms\Components\Section::make('Advertisement')->schema([
                    Forms\Components\FileUpload::make('page_content.advertisement_9.banner')->columnSpanFull()->inlineLabel(),
                    Forms\Components\TextInput::make('page_content.advertisement_9.redirect-url')->url()->columnSpanFull()->inlineLabel(),
                ])->columnSpanFull()->collapsible()->collapsed(),


            ];
        } elseif ($page == 'Privacy Policy') {
            return [
                Forms\Components\RichEditor::make('page_content.description')->columnSpanFull()->inlineLabel(),
            ];
        } elseif ($page == 'Contact us') {
            return [
                Forms\Components\FileUpload::make('page_content.thumbnail')->columnSpanFull()->inlineLabel(),
            ];
        } elseif ($page == 'Advertise with us') {
            return [
                Forms\Components\FileUpload::make('page_content.thumbnail')->columnSpanFull()->inlineLabel(),
            ];
        } elseif ($page == 'Travel Agent Membership') {
            return [
                Forms\Components\RichEditor::make('page_content.description')->columnSpanFull()->inlineLabel(),
            ];
        } elseif ($page == 'Become a TravelQuoter Partner') {
            return [
                Forms\Components\RichEditor::make('page_content.description')->columnSpanFull()->inlineLabel(),
            ];
        } elseif ($page == 'Terms And Conditions') {
            return [
                Forms\Components\RichEditor::make('page_content.description')->columnSpanFull()->inlineLabel(),
            ];
        } elseif ($page == 'Faq') {
            return [
                Forms\Components\Placeholder::make('')->content('Your Faq will be visible here'),
                Forms\Components\Section::make('Need a Help Section')->schema([
                    Forms\Components\TextInput::make('page_content.need_help_section.title')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('page_content.need_help_section.subtitle')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('page_content.need_help_section.btn_1_label')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('page_content.need_help_section.btn_1_link')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('page_content.need_help_section.btn_2_label')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('page_content.need_help_section.btn_2_link')->columnSpanFull()->inlineLabel()->required(),
                ]),
            ];
        } elseif ($page == 'Register') {
            return [
                Forms\Components\Section::make('')->schema([
                    Forms\Components\FileUpload::make('page_content.thumbnail')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('page_content.title')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('page_content.subtitle')->columnSpanFull()->inlineLabel()->required(),
                ]),
            ];
        } elseif ($page == 'Login') {
            return [
                Forms\Components\Section::make('')->schema([
                    Forms\Components\FileUpload::make('page_content.thumbnail')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('page_content.title')->columnSpanFull()->inlineLabel()->required(),
                    Forms\Components\TextInput::make('page_content.subtitle')->columnSpanFull()->inlineLabel()->required(),
                ]),
            ];
        } else {
            return [];
        }
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'view' => Pages\ViewPage::route('/{record}'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
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
