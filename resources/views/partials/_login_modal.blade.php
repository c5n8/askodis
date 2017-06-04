<div id="loginModal" class="ui small modal">
  <div class="header">
    @lang('You need to login first')
  </div>
  <div class="content">
    <form class="ui form" action="{{ route('login') }}" method="post">
      {{ csrf_field() }}

      <div class="field">
        <label for="email">@lang('E-mail Address')</label>
        <input id="email" type="email" name="email">
      </div>

      <div class="field">
        <label for="password">@lang('Password')</label>
        <input id="password" type="password" name="password">
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

      <a href="{{ route('password.request') }}">@lang('Forgot The Password')</a>
    </form>
  </div>
</div>
