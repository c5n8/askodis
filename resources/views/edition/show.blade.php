@extends('layouts.app')

@section('title', 'Edit suggestion')

@section('content')
  <div class="ui main text container">
    <h3 class="ui header"><a style="color: black" href="{{ url($question->slug) }}">{{ $question->body }}</a></h3>

    @if ($question->hasDetail)
      <p>{{ $question->detail }}</p>
    @endif

    <div class="ui divider"></div>
  </div>

  <edition-comparation
    v-cloak
    :id="{{ $edition->id }}"
    init-status="{{ $edition->status }}"
    created-at="{{ $edition->created_at }}"
    updated-at="{{ $edition->updated_at }}">
    <strong slot='user'>{{ $edition->user->name }}</strong>

    <div slot='data' id="originalEdit">
      {{ $originalEdition->text }}
    </div>
    <div slot='data' id="suggestedEdit">
      {{ $edition->text }}
    </div>
  </edition-comparation>
@endsection
