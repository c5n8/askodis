@extends('layouts.app')

@section('title', config('app.name'))

@section('meta')
  <meta property="og:url"           content="https://askodis.com" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="Askodis" />
  <meta property="og:description"   content="@lang('Ask, answer, collaborate, translate, and more.')" />
@endsection

@section('content')
  <question-list></question-list>
@endsection
