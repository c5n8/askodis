@extends('layouts.app')

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
            <input id="name" type="text" name="name" required autofocus>
          </div>

          <div class="field">
            <label for="email">@lang('E-mail Address')</label>
            <input id="email" type="email" name="email" required>
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
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
      </div>
    </div>
  </div>
@endsection
