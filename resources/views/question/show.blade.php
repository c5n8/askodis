<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <title>
      {{ $question->body }} – {{ config('app.name') }}
    </title>
  </head>
  <body>
    <h3>
      {{ $question->body }}
    </h3>
    <p>
      @if ($question->hasDetail)
        {{ $question->detail }}
      @endif
    </p>
  </body>
</html>
