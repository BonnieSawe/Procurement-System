@extends('layouts.auth')

@section('auth-content')
<body class="animsition">
        <div class="page-wrapper">
            <div class="page-content--bge5">
                <div class="container">
                    <div class="login-wrap">
                        <div class="login-content">
                            <div class="login-logo">
							        <img class="img-responsive" alt="Church Service at House of prayer Plymouth" src="{{asset('img/house-of-prayer-ministries-logo.png')}}" style="height: 75px"/>
                            </div>
                            <div class="login-form">
                                <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                                            @csrf
                                    <div class="form-group">
                                        <label>{{ __('E-Mail Address') }}</label>
                                        <input class="au-input au-input--full{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required autofocus" type="email" name="email" placeholder="Email">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('Password') }}</label>
                                        <input class="au-input au-input--full {{ $errors->has('password') ? ' is-invalid' : '' }}" required type="password" name="password" placeholder="Password">
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="login-checkbox">
                                        <label>
                                            <input type="checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            {{ __('Remember Me') }}
                                        </label>
                                        <label>
                                            <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                        </label>
                                    </div>
                                    <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">{{ __('Login') }}</button>                                    
                                </form>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
        </div>    
@endsection
