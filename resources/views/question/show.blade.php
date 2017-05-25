@extends('layouts.app')

@section('title', $question->body)

@section('content')
  <div class="ui main text container">
    <h3 class="ui header">{{ $question->body }}</h3>

    @if ($question->hasDetail)
      <p>{{ $question->detail }}</p>
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
@endsection
