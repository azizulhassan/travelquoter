<?php

use App\Http\Controllers\Api\AccommodationTypeController;
use App\Http\Controllers\Api\AdvertisementController;
use App\Http\Controllers\Api\AdvertiseWithUsController;
use App\Http\Controllers\Api\AgencyController;
use App\Http\Controllers\Api\AgentController;
use App\Http\Controllers\Api\AirlineController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\StateController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\CarTypeController;
use App\Http\Controllers\Api\BedTypeController;
use App\Http\Controllers\Api\AmenityController;
use App\Http\Controllers\Api\BookmarkController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\ClientAgentChatController;
use App\Http\Controllers\Api\ClientClientChatController;
use App\Http\Controllers\Api\GtripChatController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\CruiseAdditionalInfoController;
use App\Http\Controllers\Api\CruiseController;
use App\Http\Controllers\Api\FlightClassController;
use App\Http\Controllers\Api\FlightController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\InsuranceController;
use App\Http\Controllers\Api\NewsCategoryController;
use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\OptionController;
use App\Http\Controllers\Api\OtherController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PassportTypeController;
use App\Http\Controllers\Api\PricingPlanController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\SharedPackageController;
use App\Http\Controllers\Api\VisaController;
use App\Http\Controllers\Api\VisitPurposeController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\PaymentController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/token/check', [AuthController::class, 'check']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Attributes
    Route::get('/locations', [LocationController::class, 'index']);
    Route::post('/location/search', [LocationController::class, 'search']);
    Route::get('/countries', [CountryController::class, 'index']);
    Route::post('/country/search', [CountryController::class, 'search']);
    Route::get('/states', [StateController::class, 'index']);
    Route::post('/state/search', [StateController::class, 'search']);
    Route::get('/accommodation-types', [AccommodationTypeController::class, 'index']);
    Route::get('/amenities', [AmenityController::class, 'index']);
    Route::get('/bed-types', [BedTypeController::class, 'index']);
    Route::get('/car-types', [CarTypeController::class, 'index']);
    Route::get('/cruise-additional-infos', [CruiseAdditionalInfoController::class, 'index']);
    Route::get('/visit-purposes', [VisitPurposeController::class, 'index']);
    Route::get('/airlines', [AirlineController::class, 'index']);
    Route::get('/passport-types', [PassportTypeController::class, 'index']);
    Route::get('/flight-classes', [FlightClassController::class, 'index']);

    // Agents & Agency
    Route::get('/agents', [AgentController::class, 'index']);
    Route::post('/agent', [AgentController::class, 'store']);
    Route::post('/agent/resend-verification-mail', [AgentController::class, 'resendVerificationMail']);
    Route::post('/agent/verify-mail', [AgentController::class, 'verifyMail']);
    Route::post('/agent/search', [AgentController::class, 'search']);
    Route::post('/agent/login', [AgentController::class, 'login']);
    Route::post('/agents/filter', [AgentController::class, 'filter']);
    Route::post('/agent/google/login', [AgentController::class, 'googleLogin']);
    Route::post('/agent/forgot-password', [AgentController::class, 'forgotPassword']);
    Route::post('/agent/reset-password', [AgentController::class, 'resetPassword']);
    Route::post('/agent/changepassword/{id}', [AgentController::class, 'changepassword']);
    Route::get('/agent/{id}', [AgentController::class, 'show']);
    Route::post('/agent/{id}', [AgentController::class, 'update']);
    Route::delete('/agent/{id}', [AgentController::class, 'destroy']);
    // ----------------------------------------------------------------
    Route::get('/agencies', [AgencyController::class, 'index']);
    Route::post('/agency', [AgencyController::class, 'store']);
    Route::post('/agency/search', [AgencyController::class, 'search']);
    Route::get('/agency/{id}', [AgencyController::class, 'show']);
    Route::post('/agency/{id}', [AgencyController::class, 'update']);
    Route::delete('/agency/{id}', [AgencyController::class, 'destroy']);

    // Clients
    Route::get('/clients', [ClientController::class, 'index']);
    Route::post('/client', [ClientController::class, 'store']);
    Route::post('/client/resend-verification-mail', [ClientController::class, 'resendVerificationMail']);
    Route::post('/client/verify-mail', [ClientController::class, 'verifyMail']);
    Route::post('/client/search', [ClientController::class, 'search']);
    Route::post('/client/login', [ClientController::class, 'login']);
    Route::post('/client/google/login', [ClientController::class, 'googleLogin']);
    Route::post('/client/forgot-password', [ClientController::class, 'forgotPassword']);
    Route::post('/client/reset-password', [ClientController::class, 'resetPassword']);
    Route::post('/client/changepassword/{id}', [ClientController::class, 'changepassword']);
    Route::get('/client/{id}', [ClientController::class, 'show']);
    Route::post('/client/{id}', [ClientController::class, 'update']);
    Route::delete('/client/{id}', [ClientController::class, 'destroy']);

    // News / Blogs
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/featured', [NewsController::class, 'featured']);
    Route::post('/news/search', [NewsController::class, 'search']);
    Route::get('/news/{id}', [NewsController::class, 'show']);
    Route::get('/news-categories', [NewsCategoryController::class, 'index']);

    // Stories or Alerts
    Route::get('/stories', [StoryController::class, 'index']);
    Route::post('/story', [StoryController::class, 'create']);
    Route::post('/story/comment', [StoryController::class, 'comment']);
    Route::post('/story/assign-tag', [StoryController::class, 'assignTag']);
    Route::post('/story/like', [StoryController::class, 'like']);
    Route::get('/story/tags', [StoryController::class, 'tags']);
    Route::post('/story/search', [StoryController::class, 'search']);
    Route::post('/subscribe/agent', [StoryController::class, 'subscribeAgent']);
    Route::post('/story/update/{id}', [StoryController::class, 'update']);
    Route::get('/story/categories', [StoryController::class, 'category']);
    Route::get('/story/{id}', [StoryController::class, 'show']);

    // Faq
    Route::get('/faqs', [FaqController::class, 'index']);
    Route::get('/faq/{id}', [FaqController::class, 'show']);

    // Newsletters
    Route::get('/newsletters', [NewsletterController::class, 'index']);
    Route::post('/newsletter', [NewsletterController::class, 'store']);
    Route::post('/newsletter/search', [NewsletterController::class, 'search']);
    Route::post('/newsletter/{id}', [NewsletterController::class, 'update']);
    Route::delete('/newsletter/{id}', [NewsletterController::class, 'destroy']);

    // Flights
    Route::post('/flight/agent', [FlightController::class, 'flightAgent']);
    Route::get('/flight/{id}', [FlightController::class, 'show']);
    Route::post('/flight/search', [FlightController::class, 'search']);
    Route::post('/flight/{id}', [FlightController::class, 'update']);
    Route::delete('/flight/{id}', [FlightController::class, 'destroy']);
    Route::get('/flights', [FlightController::class, 'index']);
    Route::post('/flight', [FlightController::class, 'store']);

    // Hotels
    Route::post('/hotel/agent', [HotelController::class, 'hotelAgent']);
    Route::get('/hotels', [HotelController::class, 'index']);
    Route::post('/hotel', [HotelController::class, 'store']);
    Route::get('/hotel/{id}', [HotelController::class, 'show']);
    Route::post('/hotel/search', [HotelController::class, 'search']);
    Route::post('/hotel/{id}', [HotelController::class, 'update']);
    Route::delete('/hotel/{id}', [HotelController::class, 'destroy']);

    // Cars
    Route::post('/car/agent', [CarController::class, 'carAgent']);
    Route::get('/cars', [CarController::class, 'index']);
    Route::post('/car', [CarController::class, 'store']);
    Route::get('/car/{id}', [CarController::class, 'show']);
    Route::post('/car/search', [CarController::class, 'search']);
    Route::post('/car/{id}', [CarController::class, 'update']);
    Route::delete('/car/{id}', [CarController::class, 'destroy']);

    // Visa
    Route::post('/visa/agent', [VisaController::class, 'visaAgent']);
    Route::get('/visas', [VisaController::class, 'index']);
    Route::post('/visa', [VisaController::class, 'store']);
    Route::get('/visa/{id}', [VisaController::class, 'show']);
    Route::post('/visa/search', [VisaController::class, 'search']);
    Route::post('/visa/{id}', [VisaController::class, 'update']);
    Route::delete('/visa/{id}', [VisaController::class, 'destroy']);

    // Insurance
    Route::post('/insurance/agent', [InsuranceController::class, 'insuranceAgent']);
    Route::get('/insurances', [InsuranceController::class, 'index']);
    Route::post('/insurance', [InsuranceController::class, 'store']);
    Route::get('/insurance/{id}', [InsuranceController::class, 'show']);
    Route::post('/insurance/search', [InsuranceController::class, 'search']);
    Route::post('/insurance/{id}', [InsuranceController::class, 'update']);
    Route::delete('/insurance/{id}', [InsuranceController::class, 'destroy']);
    Route::post('/update/agent/services', [AgentController::class, 'fAddMultipleAgentServices']);

    // Cruise
    Route::post('/cruise/agent', [CruiseController::class, 'cruiseAgent']);
    Route::get('/cruises', [CruiseController::class, 'index']);
    Route::post('/cruise', [CruiseController::class, 'store']);
    Route::get('/cruise/{id}', [CruiseController::class, 'show']);
    Route::post('/cruise/search', [CruiseController::class, 'search']);
    Route::post('/cruise/{id}', [CruiseController::class, 'update']);
    Route::delete('/cruise/{id}', [CruiseController::class, 'destroy']);

    // Packages & Offers
    Route::get('/offers', [OfferController::class, 'index']);
    Route::get('/offer/{id}', [OfferController::class, 'show']);
    Route::post('/offer/search', [OfferController::class, 'search']);
    Route::post('/offer', [OfferController::class, 'store']);
    Route::post('/offer/{id}', [OfferController::class, 'update']);
    Route::delete('/offer/{id}', [OfferController::class, 'destroy']);

    // Gtrip / Shared Packages
    Route::get('/shared-packages', [SharedPackageController::class, 'index']);
    Route::get('/shared-package/{id}', [SharedPackageController::class, 'show']);
    Route::post('/shared-package/search', [SharedPackageController::class, 'search']);
    Route::post('/shared-package', [SharedPackageController::class, 'store']);
    Route::post('/shared-package/{id}', [SharedPackageController::class, 'update']);
    Route::delete('/shared-package/{id}', [SharedPackageController::class, 'destroy']);

    // Setting
    Route::get('/settings', [SettingController::class, 'index']);
    Route::get('/setting/{id}', [SettingController::class, 'show']);

    // Quotes
    Route::get('/quotes', [QuoteController::class, 'index']);
    Route::get('/latest/quotes', [QuoteController::class, 'latestQuotes']);
    Route::post('/quote/search', [QuoteController::class, 'search']);
    Route::post('/quote', [QuoteController::class, 'store']);
    Route::get('/quote/{id}', [QuoteController::class, 'show']);
    Route::post('/quote/{id}', [QuoteController::class, 'update']);
    Route::delete('/quote/{id}', [QuoteController::class, 'destroy']);

    // Pages
    Route::get('/pages', [PageController::class, 'index']);
    Route::get('/page/{id}', [PageController::class, 'show']);

    // Contact
    Route::post('/contacts', [ContactController::class, 'store']);

    // Advertise with us
    Route::get('/advertise-with-us', [AdvertiseWithUsController::class, 'index']);
    Route::post('/advertise-with-us', [AdvertiseWithUsController::class, 'store']);
    Route::delete('/advertise-with-us/{id}', [AdvertiseWithUsController::class, 'destroy']);

    // Client and Agent Chats
    Route::get('/client-agent-chats', [ClientAgentChatController::class, 'index']);
    Route::get('/client-agent-chat/{id}', [ClientAgentChatController::class, 'show']);
    Route::delete('/client-agent-chat/{id}', [ClientAgentChatController::class, 'destroy']);
    Route::post('/client-agent-chat', [ClientAgentChatController::class, 'store']);
    Route::post('/client-agent-chat/{id}', [ClientAgentChatController::class, 'update']);

    // Client and Client Chats
    Route::get('/client-client-chats', [ClientClientChatController::class, 'index']);
    Route::get('/client-client-chat/{id}', [ClientClientChatController::class, 'show']);
    Route::delete('/client-client-chat/{id}', [ClientClientChatController::class, 'destroy']);
    Route::post('/client-client-chat', [ClientClientChatController::class, 'store']);
    Route::post('/client-client-chat/{id}', [ClientClientChatController::class, 'update']);

    // Gtrip Chats
    Route::get('/gtrip-chats', [GtripChatController::class, 'index']);
    Route::get('/gtrip-chat/{id}', [GtripChatController::class, 'show']);
    Route::delete('/gtrip-chat/{id}', [GtripChatController::class, 'destroy']);
    Route::post('/gtrip-chat', [GtripChatController::class, 'store']);
    Route::post('/gtrip-chat/{id}', [GtripChatController::class, 'update']);

    //payment

    Route::post('/add/payment', [PaymentController::class, 'fAdd']);
    Route::get('/stripe/success', [PaymentController::class, 'fSuccess']);
    Route::get('/stripe/cancel', [PaymentController::class, 'fCancel']);

    // Bookmark
    Route::get('/bookmarks/agents/{agent_id}', [BookmarkController::class, 'agentBookmarks']);
    Route::get('/bookmarks/clients/{client_id}', [BookmarkController::class, 'clientBookmarks']);
    Route::post('/bookmarks/clients', [BookmarkController::class, 'storeClient']);
    Route::post('/bookmarks/agents', [BookmarkController::class, 'storeAgent']);
    Route::delete('/bookmarks/agents/{agent_id}/{id}', [BookmarkController::class, 'removeAgentBookmark']);
    Route::delete('/bookmarks/clients/{client_id}/{id}', [BookmarkController::class, 'removeClientBookmark']);

    // Famous Places
    Route::get('/famous-places', [OtherController::class, 'famousPlaces']);

    // Pricing Plan
    Route::get('/pricing-plans', [PricingPlanController::class, 'index']);
});
