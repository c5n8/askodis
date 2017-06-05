@extends('auth.layouts.app')

@section('content')
<div class="ui main container" style="margin-top: 5em">
  <div class="ui centered grid">
    <div class="eight wide computer sixteen wide mobile column">
      <h3 class="ui header">
        @lang('Login')
      </h3>

      <form class="ui form" action="{{ route('login') }}" method="post">
        {{ csrf_field() }}

        <div class="field">
          <label for="email">@lang('E-mail Address')</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="field">
          <label for="password">@lang('Password')</label>
          <input id="password" type="password" name="password" required>
        </div>

        <div class="inline field">
          <div class="ui checkbox">
            <input type="checkbox" name="remember " tabindex="0" class="hidden">
            <label>@lang('Remember me')</label>
          </div>
        </div>

        <button type="submit" class="ui tiny green button">
          <i class="sign in icon"></i>
          @lang('Login')
        </button>

        <a href="{{ route('password.request') }}">@lang('Forgot Password')</a>
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
