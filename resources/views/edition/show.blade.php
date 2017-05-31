@extends('layouts.app')

@section('title', 'Edit suggestion')

@section('content')
  <div class="ui main text container">
    <h3 class="ui header">{{ $question->body }}</h3>

    @if ($question->hasDetail)
      <p>{{ $question->detail }}</p>
    @endif

    <div class="ui divider"></div>
  </div>

  <edition-comparation
    v-cloak
    :id="{{ $suggestedEdit->id }}"
    init-status="{{ $suggestedEdit->status }}"
    created-at="{{ $suggestedEdit->created_at }}"
    updated-at="{{ $suggestedEdit->updated_at }}">
    <strong slot='user'>{{ $suggestedEdit->user->name }}</strong>

    <div slot='data' id="originalEdit">
      {{ $originalEdit->text }}
    </div>
    <div slot='data' id="suggestedEdit">
      {{ $suggestedEdit->text }}
    </div>
  </edition-comparation>
@endsection
