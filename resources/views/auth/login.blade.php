@extends('layouts.auth')

@section('content')
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(template/core/app/media/img/bg/bg-3.jpg);">
        <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
            <div class="m-login__container">
                <div class="m-login__logo" style="text-align:left;">
                    <a href="#">
                        <img src="template/app/media/img/icons/DDlogo.png">
                    </a>
                </div>
                <div class="m-login__signin">
                    <div class="m-login__head">
                        <h3 class="m-login__title">
                            Login to your account
                        </h3>
                    </div>
                    <form class="m-login__form m-form" action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="form-group m-form__group">
                            <input type="text" placeholder="{{ __('E-Mail Address') }}" name="email" autocomplete="off" class="form-control m-input {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group m-form__group">
                            <input type="password" class="form-control m-input m-login__form-input--last{{ $errors->has('password') ? ' is-invalid' : '' }}" id="signin-password"  placeholder="Password" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="row m-login__form-sub">
                            <div class="col m--align-left m-login__form-left">
                                <label class="m-checkbox  m-checkbox--focus">
                                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    {{ __('Remember Me') }}
                                    <span></span>
                                </label>
                            </div>

                            <div class="col m--align-right m-login__form-right">
                                <a href="/password-reset" class="m-link">
                                    Forget Password ?
                                </a>
                            </div>
                        </div>

                        <div class="m-login__form-action">
                            <button type="submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-script')
    
@endsection