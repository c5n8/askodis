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
          <option value="">Locale</option>
          <option value="{{ $locale->code }}"
            {{ $locale->id == $settings['locale']->id ? 'selected' : '' }}
          >
            {{ $locale->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="field ten wide">
      <label>@lang('Spoken Languages')</label>
      <select class="ui fluid search dropdown" name="languages[]" multiple>
        <option value="">Language</option>
        @foreach ($languages as $language)
          <option value="{{ $language->code }}"
              {{ in_array($language->id, $settings['languages']->pluck('id')->toArray()) ? 'selected' : '' }}
          >{{ $language->name }}</option>
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
