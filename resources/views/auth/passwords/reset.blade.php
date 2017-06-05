@extends('auth.layouts.app')

@section('content')
  <div class="ui main container" style="margin-top: 5em">
    <div class="ui centered grid">
      <div class="eight wide computer sixteen wide mobile column">
        <h3 class="ui header">
          @lang('Reset Password')
        </h3>

        <form class="ui form" action="{{ route('password.request') }}" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="token" value="{{ $token }}">

          <div class="field">
            <label for="email">@lang('E-mail Address')</label>
            <input id="email" type="email" name="email" value="{{ $email }}" required autofocus>
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
            @lang('Reset Password')
          </button>
        </form>

      </div>
    </div>
  </div>
@endsection
