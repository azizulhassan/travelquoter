@extends('layouts.page')
@section('seo')
    <title>{{ __('Agency List Page') }}</title>
    <meta name="description" content="{{ __('Agency List Page') }}">
    <meta name="author" content="{{ __(env('APP_NAME')) }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ __(route('home')) }}">
    <meta property="og:title" content="{{ __('Agency List Page') }}">
    <meta property="og:description" content="{{ __('Agency List Page') }}">
    <meta property="og:image" content="{{ asset('uploads/about_us_thumbnail.png') }}">
    <meta property="twitter:card" content="{{ asset('uploads/about_us_thumbnail.png') }}">
    <meta property="twitter:url" content="{{ route('home') }}">
    <meta property="twitter:title" content=" {{ __('Agency List Page') }}">
    <meta property="twitter:description" content="{{ __('Agency List Page') }}">
    <meta property="twitter:image" content="{{ asset('uploads/about_us_thumbnail.png') }}">
@stop
@section('content')
    <main class="max-w-screen-md px-6 mx-auto py-12">
        <h2 class="font-roman text-3xl font-medium">{{ __('Agency Listing') }}</h2>
        <p class="text-sm mt-1">{{ __('Subscribe and get alerted with daily travel news from your favourate agency.') }}</p>
        <div class="mt-6">
            <livewire:agency-list-filter />
        </div>
    </main>
@stop
