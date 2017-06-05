@extends('auth.layouts.app')

@section('content')
  <div class="ui main container" style="margin-top: 5em">
    <div class="ui centered grid">
      <div class="eight wide computer sixteen wide mobile column">
        <h3 class="ui header">
          @lang('Reset Password')
        </h3>

        <form class="ui form" action="{{ route('password.email') }}" method="post">
          {{ csrf_field() }}

          <div class="field">
            <label for="email">@lang('E-mail Address')</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
          </div>

          <button type="submit" class="ui tiny green button">
            <i class="mail icon"></i>
            @lang('Send Password Reset Link')
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

        @if (session('status'))
          <div class="ui positive message">
            <div class="description">
              {{ session('status') }}
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection
