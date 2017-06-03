@extends('layouts.app')

@section('title', __('Settings') . ' – ' . config('app.name'))

@section('content')
<div class="ui main text container">
  <form id="settingsForm" class="ui form" action="{{ url('my/settings')}}" method="post">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}

    <div class="field six wide">
      <label>
        @lang('Interface Language')
      </label>
      <select class="ui search dropdown" name="locale">
        @foreach ($locales as $locale)
          <option value="">Language</option>
          <option value="{{ $locale->code }}"
            {{ $locale->code == $settings['locale']->code ? 'selected' : '' }}
          >
            {{ $locale->name }}
          </option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="ui green tiny button">
      <i class="save icon"></i>
      @lang('Save')
    </button>
  </form>
</div>
@endsection
