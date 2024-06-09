<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Agent;
use App\Models\News;
use App\Models\Offer;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Setting;

class PageController extends Controller
{
    public $setting;

    public function __construct()
    {
        $this->setting = Setting::findorFail(1);
    }

    public function getPage($id)
    {
        return Page::where('status', true)->findorFail($id);
    }

    public function index()
    {
        return view('pages.index', [
            'setting' => $this->setting,
            'data' => $this->getPage(1),
            'offers' => Offer::with(['user', 'agent'])->where('status', true)->where('is_featured', true)->orderBy('created_at', 'DESC')->limit(10)->get(),
            'agencies' => Agency::with(['agent'])->orderBy('created_at', 'DESC')->limit(10)->get(),
        ]);
    }

    public function about()
    {
        return view('pages.about', [
            'setting' => $this->setting,
            'data' => $this->getPage(2)
        ]);
    }

    public function whyUs()
    {
        return view('pages.why-us', [
            'setting' => $this->setting,
            'data' => $this->getPage(2)
        ]);
    }

    public function contact()
    {
        return view('pages.contact', [
            'setting' => $this->setting,
            'data' => $this->getPage(5)
        ]);
    }

    public function faq()
    {
        return view('pages.faq', [
            'setting' => $this->setting,
            'data' => $this->getPage(9),
        ]);
    }

    public function advertiseWithUs()
    {
        return view('pages.advertise', [
            'setting' => $this->setting,
            'data' => $this->getPage(6)
        ]);
    }

    public function agentMembership()
    {
        return view('pages.membership', [
            'setting' => $this->setting,
            'data' => $this->getPage(7)
        ]);
    }

    public function terms()
    {
        return view('pages.terms', [
            'setting' => $this->setting,
            'data' => $this->getPage(4)
        ]);
    }

    public function privacy()
    {
        return view('pages.privacy', [
            'setting' => $this->setting,
            'data' => $this->getPage(3)
        ]);
    }

    public function blogs()
    {
        return view('pages.news.index', [
            'setting' => $this->setting,
            'data' => $this->getPage(32),
        ]);
    }

    public function alerts()
    {
        return view('pages.alerts', [
            'setting' => $this->setting,
            'data' => $this->getPage(33),
        ]);
    }

    public function singleBlog($slug)
    {
        $array = explode('-', $slug);
        $id = end($array);

        return view('pages.news.single', [
            'setting' => $this->setting,
            'blog' => News::where('status', true)->findorFail($id),
            'trending' => News::where('status', true)->where('is_featured', true)->orderBy('created_at', 'DESC')->skip(3)->limit(8)->get(),
        ]);
    }

    public function offers()
    {
        return view('pages.offers.index', [
            'setting' => $this->setting,
        ]);
    }

    public function agencyList()
    {
        return view('pages.agency-list', [
            'setting' => $this->setting
        ]);
    }

    public function offerRequest($slug)
    {
        $array = explode('-', $slug);
        $id = end($array);

        return view('pages.offers.request', [
            'setting' => $this->setting,
            'offer' => Offer::where('status', true)->findorFail($id),
        ]);
    }

    public function singleOffer($slug)
    {
        $array = explode('-', $slug);
        $id = end($array);

        $offer = Offer::where('status', true)->findorFail($id);

        return view('pages.offers.single', [
            'setting' => $this->setting,
            'offer' => $offer,
            'offers' => Offer::where('status', true)->where('agent_id', $offer->agent_id)->orderBy('created_at', 'DESC')->limit(4)->get(),
            'agencies' => Agency::where('status', true)->orderBy('created_at', 'DESC')->limit(3)->get()
        ]);
    }

    public function clientLogin()
    {
        return view('dashboard.client.auth.login', [
            'setting' => $this->setting,
            'data' => $this->getPage(11),
        ]);
    }

    public function clientRegister()
    {
        return view('dashboard.client.auth.register', [
            'setting' => $this->setting,
            'data' => $this->getPage(11),
        ]);
    }

    public function clientVerifyAccount()
    {
        return view('dashboard.client.auth.email-verify', [
            'setting' => $this->setting,
            'data' => $this->getPage(11),
        ]);
    }

    
    public function agentVerifyAccount()
    {
        return view('dashboard.agent.auth.email-verify', [
            'setting' => $this->setting,
            'data' => $this->getPage(11),
        ]);
    }

    public function agentLogin()
    {
        return view('dashboard.agent.auth.login', [
            'setting' => $this->setting,
            'data' => $this->getPage(11),
        ]);
    }

    public function agentRegister()
    {
        return view('dashboard.agent.auth.register', [
            'setting' => $this->setting,
            'data' => $this->getPage(11),
        ]);
    }

    public function flightStep1()
    {
        return view('pages.flight.step-1', [
            'setting' => $this->setting,
            'data' => $this->getPage(14),
        ]);
    }

    public function flightStep2()
    {
        return view('pages.flight.step-2', [
            'setting' => $this->setting,
            'data' => $this->getPage(15),
        ]);
    }

    public function flightStep3()
    {
        return view('pages.flight.step-3', [
            'setting' => $this->setting,
            'data' => $this->getPage(16),
        ]);
    }

    public function hotelStep1()
    {
        return view('pages.hotel.step-1', [
            'setting' => $this->setting,
            'data' => $this->getPage(17),
        ]);
    }

    public function hotelStep2()
    {
        return view('pages.hotel.step-2', [
            'setting' => $this->setting,
            'data' => $this->getPage(18),
        ]);
    }

    public function hotelStep3()
    {
        return view('pages.hotel.step-3', [
            'setting' => $this->setting,
            'data' => $this->getPage(19),
        ]);
    }

    public function carStep1()
    {
        return view('pages.car.step-1', [
            'setting' => $this->setting,
            'data' => $this->getPage(20),
        ]);
    }

    public function carStep2()
    {
        return view('pages.car.step-2', [
            'setting' => $this->setting,
            'data' => $this->getPage(21),
        ]);
    }

    public function carStep3()
    {
        return view('pages.car.step-3', [
            'setting' => $this->setting,
            'data' => $this->getPage(22),
        ]);
    }

    public function cruiseStep1()
    {
        return view('pages.cruise.step-1', [
            'setting' => $this->setting,
            'data' => $this->getPage(23),
        ]);
    }

    public function cruiseStep2()
    {
        return view('pages.cruise.step-2', [
            'setting' => $this->setting,
            'data' => $this->getPage(24),
        ]);
    }

    public function cruiseStep3()
    {
        return view('pages.cruise.step-3', [
            'setting' => $this->setting,
            'data' => $this->getPage(25),
        ]);
    }

    public function insuranceStep1()
    {
        return view('pages.insurance.step-1', [
            'setting' => $this->setting,
            'data' => $this->getPage(26),
        ]);
    }

    public function insuranceStep2()
    {
        return view('pages.insurance.step-2', [
            'setting' => $this->setting,
            'data' => $this->getPage(27),
        ]);
    }

    public function insuranceStep3()
    {
        return view('pages.insurance.step-3', [
            'setting' => $this->setting,
            'data' => $this->getPage(28),
        ]);
    }

    public function visaStep1()
    {
        return view('pages.visa.step-1', [
            'setting' => $this->setting,
            'data' => $this->getPage(29),
        ]);
    }

    public function visaStep2()
    {
        return view('pages.visa.step-2', [
            'setting' => $this->setting,
            'data' => $this->getPage(30),
        ]);
    }

    public function visaStep3()
    {
        return view('pages.visa.step-3', [
            'setting' => $this->setting,
            'data' => $this->getPage(31),
        ]);
    }

    public function singleAgent($slug)
    {
        $array = explode('-', $slug);
        $id = end($array);

        $agent = Agent::with(['offers', 'quotes', 'agency', 'reviews'])->findorFail($id);

        return view('pages.agents.single', [
            'setting' => $this->setting,
            'data' => $this->getPage(31),
            'agent' => $agent
        ]);
    }


    public function gtripStep1()
    {
        return view('pages.gtrip.step-1', [
            'setting' => $this->setting,
            'data' => $this->getPage(14),
        ]);
    }

    public function gtripStep2()
    {
        return view('pages.gtrip.step-2', [
            'setting' => $this->setting,
            'data' => $this->getPage(14),
        ]);
    }


    public function packageStep1()
    {
        return view('pages.package.step-1', [
            'setting' => $this->setting,
            'data' => $this->getPage(29),
        ]);
    }

    public function packageStep2()
    {
        return view('pages.package.step-2', [
            'setting' => $this->setting,
            'data' => $this->getPage(30),
        ]);
    }

    public function packageStep3()
    {
        return view('pages.package.step-3', [
            'setting' => $this->setting,
            'data' => $this->getPage(31),
        ]);
    }
}
