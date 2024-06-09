<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AccommodationType;
// use App\Models\Advertisement;
use App\Models\AdvertiseWithUs;
use App\Models\Agency;
use App\Models\Agent;
use App\Models\AgentReview;
use App\Models\Airline;
use App\Models\Amenity;
use App\Models\BedType;
use App\Models\CarType;
use App\Models\Client;
use App\Models\Country;
use App\Models\CruiseAdditionalInfo;
use App\Models\Faq;
use App\Models\FlightClass;
use App\Models\Insurance;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsCategoryNews;
use App\Models\Offer;
use App\Models\Page;
use App\Models\PassportType;
use App\Models\Setting;
use App\Models\State;
use App\Models\Story;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Visa;
use App\Models\VisitPurpose;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Panel',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin1234'),
            'email_verified_at' => Carbon::now()
        ]);

        foreach (config('travelquoter.countries') as $country => $states) {
            $db_country = Country::create([
                'user_id' => 1,
                'name' => $country,
                'slug' => Str::slug($country),
                'status' => true
            ]);

            foreach ($states as $state) {
                if (!State::where('slug', Str::slug($state))->first()) {
                    State::create([
                        'user_id' => 1,
                        'country_id' => $db_country->id,
                        'name' => $state,
                        'slug' => Str::slug($state),
                        'status' => true
                    ]);
                }
            }
        }

        $stateCount = State::count();
        $state = State::findorFail(1);

        $agent = Agent::create([
            'cover' => '01.jpg',
            'profile_picture' => '01.jpg',
            'name' => fake()->name(),
            'contact_number' => fake()->phoneNumber(),
            'password' => Hash::make('admin1234'),
            'email' => 'admin@admin.com',
            'token' => Str::random(100),
            'profession' => '{}',
            'verification_code' => NULL,
            'email_verified_at' => Carbon::now(),
            'status' => true,
            'user_id' => NULL
        ]);

        Agency::create([
            'agent_id' => $agent->id,
            'agency_name' => fake()->name(),
            'mobile_number' => fake()->phoneNumber(),
            'abn_acn' => Str::random(6),
            'website_url' => 'https://staging.travelquoter.com',
            'do_you_operate_outside_australia' => [true, false][rand(0, 1)],
            'do_you_operate_through_your_website' => [true, false][rand(0, 1)],
            'business_description' => fake()->paragraph(),
            'country_id' => $state->country_id,
            'state_id' => $state->id,
            'services' => '{}',
            'street_address' => fake()->streetAddress(),
            'postcode' => fake()->postcode(),
            'status' => true,
        ]);


        for ($i = 1; $i <= 10; $i++) {
            Faq::create([
                'question' => fake()->sentence(rand(10, 20)),
                'answer' => fake()->paragraph(rand(5, 10)),
                'status' => true,
                'agent_id' => $agent->id,
            ]);
        }

        Client::create([
            'cover' => '01.jpg',
            'profile_picture' => '01.jpg',
            'country_id' => $state->country_id,
            'state_id' => $state->id,
            'street_address' => fake()->streetAddress(),
            'postcode' => fake()->postcode(),
            'name' => fake()->name(),
            'contact_number' => fake()->phoneNumber(),
            'password' => Hash::make('admin1234'),
            'email' => 'admin@admin.com',
            'token' => Str::random(100),
            'verification_code' => NULL,
            'email_verified_at' => Carbon::now(),
            'status' => true,
            'user_id' => NULL
        ]);

        for ($i = 1; $i <= 20; $i++) {
            $stateCount = State::count();
            $state = State::findorFail(rand(1, $stateCount));

            Client::create([
                'cover' => rand(11, 31).'.jpg',
                'profile_picture' => rand(11,31).'.jpg',
                'country_id' => $state->country_id,
                'state_id' => $state->id,
                'street_address' => fake()->streetAddress(),
                'postcode' => fake()->postcode(),
                'name' => fake()->name(),
                'contact_number' => fake()->phoneNumber(),
                'password' => Hash::make('admin1234'),
                'email' => 'admin@admin.com',
                'token' => Str::random(100),
                'verification_code' => NULL,
                'email_verified_at' => Carbon::now(),
                'status' => true,
                'user_id' => NULL
            ]);
        }


        for ($i = 1; $i <= 20; $i++) {
            $agent = Agent::create([
                'cover' => rand(11, 31) . '.jpg',
                'profile_picture' => rand(11, 31) . '.jpg',
                'name' => fake()->name(),
                'contact_number' => fake()->phoneNumber(),
                'password' => Hash::make('agent1234'),
                'email' => fake()->unique()->safeEmail(),
                'token' => Str::random(100),
                'profession' => '{}',
                'verification_code' => NULL,
                'email_verified_at' => Carbon::now(),
                'status' => true,
                'user_id' => NULL
            ]);

            $stateCount = State::count();
            $state = State::findorFail(rand(1, $stateCount));

            Agency::create([
                'agent_id' => $agent->id,
                'agency_name' => fake()->name(),
                'mobile_number' => fake()->phoneNumber(),
                'abn_acn' => Str::random(6),
                'website_url' => 'https://staging.travelquoter.com',
                'do_you_operate_outside_australia' => [true, false][rand(0, 1)],
                'do_you_operate_through_your_website' => [true, false][rand(0, 1)],
                'business_description' => fake()->paragraph(),
                'country_id' => $state->country_id,
                'state_id' => $state->id,
                'services' => '{}',
                'street_address' => fake()->streetAddress(),
                'postcode' => fake()->postcode(),
                'status' => true,
            ]);

            for ($j = 1; $j <= 10; $j++) {
                Faq::create([
                    'question' => fake()->sentence(10),
                    'answer' => fake()->paragraph(6),
                    'status' => true,
                    'agent_id' => $agent->id,
                ]);
            }
        }

        for ($i = 1; $i <= 100; $i++) {
            $rand =  rand(1, 21);
            AgentReview::create([
                'agent_id' => $rand,
                'client_id' => $rand,
                'name' => Client::find($rand)->name,
                'email' => Client::find($rand)->email,
                'rating' => rand(1, 5),
                'review' => fake()->paragraph(6),
                'status' => true,
            ]);
        }


        for ($i = 0; $i < 10; $i++) {

            $stateCount = State::count();
            $state = State::findorFail(rand(1, $stateCount));

            Client::create([
                'cover' => 'cover-' . $i + 1 . '.png',
                'profile_picture' => 'profile-' . $i + 1 . '.png',
                'country_id' => $state->country_id,
                'state_id' => $state->id,
                'street_address' => fake()->streetAddress(),
                'postcode' => fake()->postcode(),
                'name' => fake()->name(),
                'contact_number' => fake()->phoneNumber(),
                'password' => Hash::make('agent1234'),
                'email' => fake()->unique()->safeEmail(),
                'token' => Str::random(100),
                'verification_code' => NULL,
                'email_verified_at' => Carbon::now(),
                'status' => true,
                'user_id' => NULL,
            ]);
        }


        $story_categories = array('Flights', 'Hotels', 'Cars', 'Visa', 'Insurance');

        for ($i = 0; $i < 10; $i++) {
            Story::create([
                'agent_id' => 1,
                'category' => $story_categories[rand(0, 4)],
                'content' => fake()->paragraph(),
                'image' => rand(11, 31) . '.jpg',
                'status' => true,
            ]);
        }


        foreach (config('travelquoter.news_categories') as $key => $category) {
            NewsCategory::create([
                'user_id' => 1,
                'order' => $key + 1,
                'name' => $category,
                'slug' => Str::slug($category),
                'status' => true,
            ]);
        }

        for ($i = 1; $i <= 31; $i++) {
            $news = News::create([
                'title' => fake()->sentence(),
                'slug' => Str::slug(fake()->sentence()),
                'thumbnail' => rand(11, 31) . '.jpg',
                'short_description' => fake()->paragraph(),
                'description' => fake()->paragraph(10),
                'is_featured' => true,
                'featured_video' => NULL,
                'written_by' => fake()->name(),
                'status' => true,
            ]);

            $totalNewsCategory = NewsCategory::count();

            NewsCategoryNews::create([
                'news_id' => $news->id,
                'news_category_id' => rand(1, $totalNewsCategory),
            ]);
        }

        foreach (config('travelquoter.offers') as $offer) {
            Offer::create([
                'agent_id' => 1,
                'title' => $offer['title'],
                'extra_field' => [
                    'destination' => fake()->streetAddress(),
                    'package_include' => [
                        fake()->sentence(2), fake()->sentence(1), fake()->sentence(4)
                    ],
                    'traveling_from' => Carbon::now(),
                    'traveling_to' => Carbon::now()->addDays(15),
                    'famous_places' => [
                        fake()->streetAddress(), fake()->streetAddress(), fake()->streetAddress(), fake()->streetAddress(), fake()->streetAddress(), fake()->streetAddress()
                    ],
                ],
                'category' => array('Daily Deals', 'Top Offers', 'Recommended', 'Others')[rand(0, 3)],
                'previous_price' => rand(100, 200),
                'current_price' => rand(200, 300),
                'person' => rand(3, 10),
                'thumbnail' => 'offer_' . rand(1, 10) . '.png',
                'description' => $offer['description'],
                'is_featured' => [true, false][rand(0, 1)],
                'valid_from' => Carbon::now(),
                'valid_till' => Carbon::now()->addDays(rand(10, 20)),
                'description' => $offer['description'],
                'status' => true,
            ]);
        }

        foreach (config('travelquoter.accommodation_types') as $accommodationType) {
            AccommodationType::create([
                'user_id' => 1,
                'name' => $accommodationType,
                'slug' => Str::slug($accommodationType),
                'status' => true
            ]);
        }

        foreach (config('travelquoter.amenities') as $amenity) {
            Amenity::create([
                'user_id' => 1,
                'name' => $amenity,
                'slug' =>  Str::slug($amenity),
                'status' => true
            ]);
        }

        foreach (config('travelquoter.bed_types') as $bedType) {
            BedType::create([
                'user_id' => 1,
                'name' => $bedType,
                'slug' => Str::slug($bedType),
                'status' => true
            ]);
        }

        foreach (config('travelquoter.car_types') as $carType) {
            CarType::create([
                'user_id' => 1,
                'name' => $carType,
                'slug' => Str::slug($carType),
                'status' => true
            ]);
        }

        foreach (config('travelquoter.cruise_additional_infos') as $cruiseAdditionalInfo) {
            CruiseAdditionalInfo::create([
                'user_id' => 1,
                'name' => $cruiseAdditionalInfo,
                'slug' => Str::slug($cruiseAdditionalInfo),
                'status' => true
            ]);
        }

        foreach (config('travelquoter.visit_purposes') as $visitPurpose) {
            VisitPurpose::create([
                'user_id' => 1,
                'name' => $visitPurpose,
                'slug' => Str::slug($visitPurpose),
                'status' => true
            ]);
        }

        foreach (config('travelquoter.airlines') as $airline) {
            Airline::create([
                'user_id' => 1,
                'name' => $airline,
                'slug' => Str::slug($airline),
                'status' => true
            ]);
        }

        foreach (config('travelquoter.passport_types') as $passportType) {
            PassportType::create([
                'user_id' => 1,
                'name' => $passportType,
                'slug' => Str::slug($passportType),
                'status' => true
            ]);
        }

        foreach (config('travelquoter.flight_classes') as $flightClass) {
            FlightClass::create([
                'user_id' => 1,
                'name' => $flightClass,
                'slug' => Str::slug($flightClass),
                'status' => true
            ]);
        }

        foreach (config('travelquoter.pages') as $page) {
            Page::create([
                'title' => $page['title'],
                'subtitle' => $page['subtitle'] ?? '',
                'meta_data' => $page['meta_data'],
                'page_content' => $page['page_content'],
                'status' => true
            ]);
        }

        for ($i = 1; $i <= 10; $i++) {
            Faq::create([
                'category' => array('Account', 'Quotes', 'Payments', 'Returns')[rand(0, 3)],
                'account_type' => array('Traveller', 'Travel Agent')[rand(0, 1)],
                'question' => fake()->sentence(10),
                'answer' => fake()->paragraph(4),
                'status' => true,
                'user_id' => 1
            ]);
        }

        AdvertiseWithUs::factory(100)->create();
        Setting::create(config('travelquoter.configurations'));
        Visa::factory(10)->create();
        Insurance::factory(10)->create();
    }
}
