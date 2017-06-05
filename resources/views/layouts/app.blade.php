<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    @unless (auth()->guest())
      <meta name="user-id" content="{{ auth()->user()->id }}">
    @endunless

    <link rel="apple-touch-icon" sizes="57x57" href="{{ url('apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ url('apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ url('apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ url('apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ url('apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ url('apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ url('android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ url('favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ url('manifest.json') }}">

    @yield('meta')

    <title>
      @yield('title')
    </title>

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
  </head>
  <body>
    <div id="app">
      <div class="ui fixed menu">
        <div class="ui container">
          <a href="/" class="header item">
            {{ config('app.name') }}
            <sup>BETA</sup>
          </a>

          <search-bar></search-bar>

          <div class="right menu">
            @unless (auth()->guest())
              <notification-menu
                :count="{{ auth()->user()->unreadNotifications()->count() }}">
              </notification-menu>
              <notification-popup></notification-popup>
              <account-menu></account-menu>
            @else
              <a class="item" href="{{ url('login') }}">@lang('Login')</a>
              <a class="item" href="{{ url('register') }}">@lang('Register')</a>
            @endunless
          </div>
        </div>
      </div>

      @yield('content')

      @unless (auth()->guest())
        <question-form></question-form>
        <div id="successModal" class="ui basic small modal">
          <div class="ui positive message">
            <div class="description">
              Your edit suggestion is posted!
            </div>
          </div>
        </div>
      @else
        @include('partials._login_modal')
      @endunless
    </div>

    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>

    @if (app()->environment() == 'production')
      @include('layouts.analyticstracking')
    @endif

  </body>
</html>
