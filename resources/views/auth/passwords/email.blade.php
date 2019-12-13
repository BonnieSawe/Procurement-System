@extends('layouts.auth')

@section('auth-content')
<body class="animsition">
        <div class="page-wrapper">
            <div class="page-content--bge5">
                <div class="container">
                    <div class="login-wrap">
                        <div class="login-content">
                            <div class="login-logo">
                                {{-- <a href="/"> --}}
							        <img class="img-responsive" alt="Church Service at House of prayer Plymouth" src="{{asset('img/house-of-prayer-ministries-logo.png')}}" style="height: 75px"/>
                                {{-- </a> --}}
                            </div>
                            <div class="login-form">
                                <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                                            @csrf
                                    <div class="form-group">
                                        <label>{{ __('E-Mail Address') }}</label>
                                        <input class="au-input au-input--full{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required autofocus type="email" name="email" placeholder="Email">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>                                    
                                    <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">{{ __('Send Password Reset Link') }}</button>                                    
                                </form>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
        </div>    
@endsection

