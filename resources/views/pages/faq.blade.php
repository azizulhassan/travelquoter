@extends('layouts.page')
@section('seo')
    <title>{{ __($data->meta_data['meta_title']) }}</title>
    <meta name="description" content="{{ __($data->meta_data['meta_description']) }}" />
    <meta name="author" content="{{ __(env('APP_NAME')) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ __(route('home')) }}" />
    <meta property="og:title" content="{{ __($data->meta_data['meta_title']) }}" />
    <meta property="og:description" content="{{ __($data->meta_data['meta_description']) }}" />
    <meta property="og:image" content="{{ asset('/uploads/' . $data->meta_data['meta_thumbnail']) }}" />
    <meta property="twitter:card" content="{{ asset('/uploads/' . $data->meta_data['meta_thumbnail']) }}" />
    <meta property="twitter:url" content="{{ route('home') }}" />
    <meta property="twitter:title" content=" {{ __($data->meta_data['meta_title']) }}" />
    <meta property="twitter:description" content="{{ __($data->meta_data['meta_description']) }}" />
    <meta property="twitter:image" content="{{ asset('/uploads/' . $data->meta_data['meta_thumbnail']) }}" />
@stop
@section('content')
    <main>
        <livewire:faq-page :page="$data" />
    </main>
@stop
