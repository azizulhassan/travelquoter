<?php

namespace App\Filament\Admin\Resources\AdminResource\Widgets;

use App\Models\AccommodationType;
use App\Models\AdvertiseWithUs;
use App\Models\Airline;
use App\Models\Amenity;
use App\Models\BedType;
use App\Models\CarType;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Faq;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Newsletter;
use App\Models\Offer;
use App\Models\Page;
use App\Models\PassportType;
use App\Models\PricingPlan;
use App\Models\SharedPackage;
use App\Models\State;
use App\Models\Story;
use App\Models\User;
use App\Models\VisitPurpose;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Clients', Client::count())->url(route('filament.admin.resources.clients.index')),
            Stat::make('Offers', Offer::count())->url(route('filament.admin.resources.offers.index')),
            // Stat::make('Shared Packages / G-trip', SharedPackage::count())->url(route('filament.admin.resources.shared-packages.index')),
            Stat::make('Stories', Story::count())->url(route('filament.admin.resources.stories.index')),
            Stat::make('Users', User::count())->url(route('filament.admin.resources.users.index')),
            // Stat::make('Pages', Page::count())->url(route('filament.admin.resources.pages.index')),

            Stat::make('Accommodation Types', AccommodationType::count())->url(route('filament.admin.resources.accommodation-types.index')),
            Stat::make('Airlines', Airline::count())->url(route('filament.admin.resources.airlines.index')),
            Stat::make('Amenities', Amenity::count())->url(route('filament.admin.resources.amenities.index')),
            Stat::make('Bed Types', BedType::count())->url(route('filament.admin.resources.bed-types.index')),
            Stat::make('Car Types', CarType::count())->url(route('filament.admin.resources.car-types.index')),
            Stat::make('Passport Types', PassportType::count())->url(route('filament.admin.resources.passport-types.index')),
            Stat::make('Visit Purposes', VisitPurpose::count())->url(route('filament.admin.resources.visit-purposes.index')),

            Stat::make('Advertise With Us', AdvertiseWithUs::count())->url(route('filament.admin.resources.advertise-withuses.index')),
            Stat::make('Contacts', Contact::count())->url(route('filament.admin.resources.contacts.index')),
            Stat::make('Faqs', Faq::count())->url(route('filament.admin.resources.faqs.index')),
            Stat::make('Newsletters', Newsletter::count())->url(route('filament.admin.resources.newsletters.index')),
            Stat::make('Pricing Plans', PricingPlan::count())->url(route('filament.admin.resources.pricing-plans.index')),

            Stat::make('Countries', Country::count())->url(route('filament.admin.resources.countries.index')),
            Stat::make('States', State::count())->url(route('filament.admin.resources.states.index')),

            Stat::make('News Categories', NewsCategory::count())->url(route('filament.admin.resources.news-categories.index')),
            Stat::make('News', News::count())->url(route('filament.admin.resources.news.index')),
        ];
    }
}
