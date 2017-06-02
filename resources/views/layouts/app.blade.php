<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @unless (auth()->guest())
      <meta name="user-id" content="{{ auth()->user()->id }}">
    @endunless

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
      @endunless
    </div>

    <script type="application/json" src="{{ url('lang/' . config('app.locale') . '.json') }}"></script>
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
  </body>
</html>
