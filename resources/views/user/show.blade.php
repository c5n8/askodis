@extends('layouts.app')

@section('title', $user->name)

@section('content')
  <div class="ui main text container">
    <h3 class="ui header">{{ $user->name }}</h3>

    <p>{{ '@'.$user->username }}</p>
  </div>

  <user-question-list username='{{ $user->username }}'></user-question-list>
@endsection
