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
                            Reset Password
                        </h3>
                    </div>
                    <form class="m-login__form m-form" action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        
                        <div class="form-group m-form__group">
                            <input type="text" placeholder="{{ __('E-Mail Address') }}" name="email" autocomplete="off" class="form-control m-input {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="form-group m-form__group">
                            <input type="password" placeholder="{{ __('Password') }}" name="password" autocomplete="off" class="form-control m-input {{ $errors->has('password') ? ' is-invalid' : '' }}" required autofocus>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="form-group m-form__group">
                            <input type="password" placeholder="{{ __('Confirm Password') }}" id="password_confirmation" name="password_confirmation" autocomplete="off" class="form-control m-input"  required autofocus>

                            @if ($errors->has('password_confirmation'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                        

                        <div class="m-login__form-action">
                            <button type="submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                {{ __('Reset Password') }}
                            </button>
                        </div>

                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
