<?php

use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/about-us', [PageController::class, 'about'])->name('about');
Route::get('/why-us', [PageController::class, 'whyUs'])->name('why-us');
Route::get('/contact-us', [PageController::class, 'contact'])->name('contact');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/advertise-with-us', [PageController::class, 'advertiseWithUs'])->name('advertise-with-us');
Route::get('/agent-membership', [PageController::class, 'agentMembership'])->name('agent-membership');
Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('terms-and-conditions');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy-policy');
Route::get('/blogs', [PageController::class, 'blogs'])->name('blogs');
Route::get('/blog/{slug}', [PageController::class, 'singleBlog'])->name('blogs.single');
Route::get('/agency-list', [PageController::class, 'agencyList'])->name('agency-list');

Route::get('/agents', [PageController::class, 'agencyList'])->name('agent.index');
Route::get('/agent/{slug}', [PageController::class, 'singleAgent'])->name('agent.single');

Route::get('/offers', [PageController::class, 'offers'])->name('offers');
Route::get('/offer/{slug}', [PageController::class, 'singleOffer'])->name('offers.single');
Route::get('/offer/{slug}/request', [PageController::class, 'offerRequest'])->name('offers.request');

Route::get('/news', [PageController::class, 'blogs'])->name('blogs');
Route::get('/news/{slug}', [PageController::class, 'singleBlog'])->name('blogs.single');
Route::get('/client/login', [PageController::class, 'clientLogin'])->name('filament.client.auth.login');
Route::get('/client/verify-account', [PageController::class, 'clientVerifyAccount'])->name('filament.client.auth.verify');
Route::get('/client/register', [PageController::class, 'clientRegister'])->name('filament.client.auth.register');

Route::get('/agent/login', [PageController::class, 'agentLogin'])->name('filament.agent.auth.login');
Route::get('/agent/verify-account', [PageController::class, 'agentVerifyAccount'])->name('filament.agent.auth.verify');
Route::get('/agent/register', [PageController::class, 'agentRegister'])->name('filament.agent.auth.register');

Route::get('/flight', [PageController::class, 'flightStep1'])->name('flight.step-1');
Route::get('/flight/agent', [PageController::class, 'flightStep2'])->name('flight.step-2');
Route::get('/flight/agent/request-quote', [PageController::class, 'flightStep3'])->name('flight.step-3');

Route::get('/hotel', [PageController::class, 'hotelStep1'])->name('hotel.step-1');
Route::get('/hotel/agent', [PageController::class, 'hotelStep2'])->name('hotel.step-2');
Route::get('/hotel/agent/request-quote', [PageController::class, 'hotelStep3'])->name('hotel.step-3');

Route::get('/car', [PageController::class, 'carStep1'])->name('car.step-1');
Route::get('/car/agent', [PageController::class, 'carStep2'])->name('car.step-2');
Route::get('/car/agent/request-quote', [PageController::class, 'carStep3'])->name('car.step-3');

Route::get('/cruise', [PageController::class, 'cruiseStep1'])->name('cruise.step-1');
Route::get('/cruise/agent', [PageController::class, 'cruiseStep2'])->name('cruise.step-2');
Route::get('/cruise/agent/request-quote', [PageController::class, 'cruiseStep3'])->name('cruise.step-3');

Route::get('/insurance', [PageController::class, 'insuranceStep1'])->name('insurance.step-1');
Route::get('/insurance/agent', [PageController::class, 'insuranceStep2'])->name('insurance.step-2');
Route::get('/insurance/agent/request-quote', [PageController::class, 'insuranceStep3'])->name('insurance.step-3');

Route::get('/visa', [PageController::class, 'visaStep1'])->name('visa.step-1');
Route::get('/visa/agent', [PageController::class, 'visaStep2'])->name('visa.step-2');
Route::get('/visa/agent/request-quote', [PageController::class, 'visaStep3'])->name('visa.step-3');


Route::get('/gtrip', [PageController::class, 'gtripStep1'])->name('gtrip.step-1');
Route::get('/gtrip/details', [PageController::class, 'gtripStep2'])->name('gtrip.step-2');
// Route::get('/hotel/agent/request-quote', [PageController::class, 'hotelStep3'])->name('hotel.step-3');


Route::get('/package', [PageController::class, 'packageStep1'])->name('package.step-1');
Route::get('/package/agent', [PageController::class, 'packageStep2'])->name('package.step-2');
Route::get('/package/agent/request-quote', [PageController::class, 'packageStep3'])->name('package.step-3');


Route::get('/testing', function() {
    return view('pages.testing');
});


// Extra
Route::get('/alerts', [PageController::class, 'alerts'])->name('alerts');
