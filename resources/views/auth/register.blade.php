@extends('auth.layouts.app')

@section('title', __('Registration') . ' – ' . config('app.name'))

@section('content')
  <div class="ui main container" style="margin-top: 5em">
    <div class="ui centered grid">
      <div class="eight wide computer sixteen wide mobile column">
        <h3 class="ui header">
          @lang('Registration')
        </h3>
        <form class="ui form" action="{{ route('register') }}" method="post">
          {{ csrf_field() }}

          <div class="field">
            <label for="name">@lang('Nama')</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
          </div>

          <div class="field">
            <label for="email">@lang('E-mail Address')</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
          </div>

          <div class="field">
            <label for="username">@lang('Username')</label>
            <div class="ui labeled input">
              <div class="ui label">@</div>
              <input id="username" type="text" name="username" value="{{ old('username') }}" required>
            </div>
          </div>

          <div class="field">
            <label for="password">@lang('Password')</label>
            <input id="password" type="password" name="password" required>
          </div>

          <div class="field">
            <label for="password-confirmation">@lang('Password Confirmation')</label>
            <input id="password-confirmation" type="password" name="password_confirmation" required>
          </div>

          <button type="submit" class="ui tiny green button">
            @lang('Register')
          </button>
        </form>

        @if (count($errors) > 0)
          <div class="ui error message">
            <div class="header">
              @lang('There were some errors with your submission')
            </div>
            <ul class="list">
              @foreach ($errors->all() as $error)
                <li>@lang($error)</li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection
