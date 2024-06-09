@extends('layouts.page')
@section('seo')
    <title>{{ __('Offer Page') }}</title>
    <meta name="description" content="{{ __('Offer Page') }}">
    <meta name="author" content="{{ __(env('APP_NAME')) }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ __(route('home')) }}">
    <meta property="og:title" content="{{ __('Offer Page') }}">
    <meta property="og:description" content="{{ __('Offer Page') }}">
    <meta property="og:image" content="{{ asset('uploads/about_us_thumbnail.png') }}">
    <meta property="twitter:card" content="{{ asset('uploads/about_us_thumbnail.png') }}">
    <meta property="twitter:url" content="{{ route('home') }}">
    <meta property="twitter:title" content=" {{ __('Offer Page') }}">
    <meta property="twitter:description" content="{{ __('Offer Page') }}">
    <meta property="twitter:image" content="{{ asset('uploads/about_us_thumbnail.png') }}">
@stop
@section('content')
    <main class="max-w-screen-xl mx-auto px-6 md:px-8 py-6">
        <h2 class="font-roman text-3xl font-medium my-8">{{ __('Offers') }}</h2>
        <livewire:offers.offers-filter />
    </main>
@stop
