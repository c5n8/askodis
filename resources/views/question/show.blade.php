<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <title>
      {{ $question->body }} – {{ config('app.name') }}
    </title>

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
  </head>
  <body>
    <div class="ui main text container">
      <h3 class="ui header">
        {{ $question->body }}
      </h3>
      @if ($question->hasDetail)
        <p>
          {{ $question->detail }}
        </p>
      @endif
    </div>
  </body>
</html>
