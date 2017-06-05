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
            <input id="email" type="email" name="email" required>
          </div>

          <button type="submit" class="ui tiny green button">
            @lang('Send Password Reset Link')
          </button>
        </form>

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
