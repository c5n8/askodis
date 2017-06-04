@extends('layouts.app_min')

@section('content')
  <div class="ui main container" style="margin-top: 5em">
    <div class="ui centered grid">
      <div class="eight wide computer sixteen wide mobile column">
        <div class="ui positive message">
          <div class="description">
            @lang('We have sent email containing account activation link to')
            {{ auth()->user()->email}}
          </div>
        </div>

        <p>
          @lang('Please wait because it may take some time to be delivered to your inbox.')
        </p>
        <p>
          @lang('If it takes more than an hour you can send the link again')
        </p>
        <div class="">
          <a class='ui tiny green button' href="{{ url('account/activation/resend') }}">@lang('Send again')</a>
        </div>
      </div>
    </div>
  </div>
@endsection
