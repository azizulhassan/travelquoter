<?php

namespace App\Livewire\Offers;

use App\Models\Country;
use Livewire\Component;
use App\Models\Offer;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Attributes\Url;

class OffersFilter extends Component implements HasForms
{
    use InteractsWithForms;

    #[Url(except:'', keep:true)]
    public $category;
    public $agent;
    #[Url(except:'', keep:true)]
    public $country;
    #[Url(except:'', keep:true)]
    public $valid_from;
    #[Url(except:'', keep:true)]
    public $valid_till;
    #[Url(except:'', keep:true)]
    public $min_price;
    #[Url(except:'', keep:true)]
    public $max_price;
    #[Url(except:'', keep:true)]
    public $order_by;

    public function queryString() {
        return [
            'category',
            'country',
            'valid_from',
            'valid_till',
            'min_price',
            'max_price',
            'order_by'
        ];
    }
    
    public function form(Form $form): Form {
        return $form->schema([
            Section::make(trans('Filter By'))->schema([
                Select::make('country')->label(trans('Country'))->live()->options(Country::where('status', true)->orderBy('name', 'ASC')->pluck('name', 'name'))->searchable()->preload()->placeholder(trans('Choose Country'))->columnSpanFull(),

                Select::make('category')->label(trans('Category'))->options([
                    'Daily Deals' => trans('Daily Deals'),
                    'Top Offers' => trans('Top Offers'),
                    'Recommended' => trans('Recommended'),
                    'Others' => 'Others',
                ])->live()->searchable()->columnSpanFull()->placeholder(trans('Choose Category')),

                DatePicker::make('valid_from')->label(trans('Valid from'))->live()->native(false)->columnSpanFull()->placeholder(trans('Dec 1, 2023')),

                DatePicker::make('valid_till')->label(trans('Valid till'))->live()->native(false)->columnSpanFull()->placeholder(trans('Dec 20, 2023')),

                TextInput::make('min_price')->label(trans('Min price'))->live()->numeric()->placeholder(0)->prefix('$'),
                TextInput::make('max_price')->label(trans('Max price'))->live()->numeric()->placeholder(100)->prefix('$'),

                Select::make('order_by')->label(trans('Order by'))->options([
                    'created_at_asc' => trans('Recently Added'),
                    'created_at_desc' => trans('Old Packages')
                ])->live()->native(false)->columnSpanFull()->placeholder(trans('Any')),
            ])->columns(2)
        ]);
    }

    public function render()
    {
        $offers = Offer::where('status', true);

        if ($this->agent) {
            $offers = $offers->whereHas('agent', function (Builder $query) {
                $query->where('name', 'like', '%' . $this->agent . '%');
            });
        }

        // if ($this->country) {
        //     $offers = $offers->whereJsonContains('extra_field->destination', 'like', '%'.$this->country.'%');
        // }

        if ($this->category) {
            $offers = $offers->where('category', $this->category);
        }

        if ($this->min_price) {
            $offers = $offers->where('current_price', '>=', (int)$this->min_price);
        }

        if ($this->max_price) {
            $offers = $offers->where('current_price', '<=', (int)$this->max_price);
        }

        if ($this->valid_from) {
            $offers = $offers->where('valid_from', '>=', $this->valid_from);
        }

        if ($this->valid_till) {
            $offers = $offers->where('valid_till', '<=', $this->valid_till);
        }

        if ($this->order_by) {
            if ($this->order_by == 'created_at_asc') {
                $offers = $offers->orderBy('created_at', 'ASC');
            }
            elseif ($this->order_by == 'created_at_desc') {
                $offers = $offers->orderBy('created_at', 'DESC');
            }
            else {
                $offers = $offers->orderBy('created_at', 'DESC');
            }
        }

        $offers = $offers->limit(12)->get();

        return view('livewire.offers.offers-filter', [
            'daily_deals' => Offer::where('status', true)->orderByRaw('(previous_price - current_price) / previous_price DESC')->orderBy('created_at', 'DESC')->limit(6)->get(),
            'top_offers' => Offer::where('status', true)->orderByRaw('(previous_price - current_price) / previous_price DESC')->orderBy('created_at', 'DESC')->skip(6)->limit(6)->get(),
            'recommended_offers' => Offer::with(['user', 'agent'])->where('status', true)->where('is_featured', true)->orderBy('created_at', 'DESC')->limit(10)->get(),
            'offers' => $offers
        ]);
    }
}
