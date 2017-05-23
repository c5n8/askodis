<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
      {{ $question->body }} – {{ config('app.name') }}
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

          @unless (auth()->guest())
            <div class="right menu">
              {{-- <a href="#" class="ui item">
                <i class="bell icon"></i>
                Notifications
              </a> --}}
              <div id="accountMenu" class="ui pointing dropdown link item">
                <span class="text">Account</span>
                <i class="angle down icon"></i>
                <div class="menu">
                  <div class="item">
                    <div
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Logout
                    </div>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @endunless
        </div>
      </div>

      <div class="ui main text container">
        <h3 class="ui header">
          {{ $question->body }}
        </h3>

        @if ($question->hasDetail)
          <p>
            {{ $question->detail }}
          </p>
        @endif

        <div class="ui grid">
          <div class="sixteen wide column">
            <div class="ui small tag labels">

              @foreach ($question->tags as $tag)
                <a href="#" class="ui label">{{ $tag['body'] }}</a>
              @endforeach

            </div>
          </div>
        </div>
      </div>

      <question :id={{ $question->id }}></question>
    </div>

    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
  </body>
</html>
