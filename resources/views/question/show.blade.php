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
      <div class="ui main text container">
        <h3 class="ui header">
          {{ $question->body }}
        </h3>
        @if ($question->hasDetail)
          <p>
            {{ $question->detail }}
          </p>
        @endif
        <question :id={{ $question->id }}></question>
      </div>
    </div>

    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
  </body>
</html>
