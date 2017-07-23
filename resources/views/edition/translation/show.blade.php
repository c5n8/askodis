@extends('layouts.app')

@section('title', 'Translation suggestion')

@section('content')
  <div class="ui main text container">
    <h3 class="ui header"><a style="color: black" href="{{ url($question->slug) }}">{{ $question->body }}</a></h3>

    @if ($question->hasDetail)
      <p>{{ $question->detail }}</p>
    @endif

    <div class="ui divider"></div>
  </div>

  <edition-translation
    v-cloak
    :id="{{ $edition->id }}"
    init-status="{{ $edition->status }}"
    created-at="{{ $edition->created_at }}"
    updated-at="{{ $edition->updated_at }}"
    original-language="{{ $originalEdition->language->name }}"
    translation-language="{{ $edition->language->name }}">

    <strong slot='user'>{{ $edition->user->name }}</strong>

    <div slot='original' id="originalEdit">
      {{ $originalEdition->text }}
    </div>
    <div slot='translation' id="suggestedEdit">
      {{ $edition->text }}
    </div>
  </edition-translation>
@endsection
