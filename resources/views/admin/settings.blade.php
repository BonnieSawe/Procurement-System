@extends('layouts.dash-nav')
@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
    @include('inc.messages') 
    <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
        <a href="/manage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Settings</li>
    </ol>

    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <div class="container">
            <div class="row">


            <div class="col-lg-12">
                <!-- settings -->
                <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"> <i class="fa fa-user"></i> Personal Details</h6>
                        </div>
                        <div class="card-body">
                                {!! Form::open(['action' => ['UserController@update', Auth::user()->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}      
                                @csrf
                                {{Form::hidden('id', Auth::user()->id)}}    
                                <div class="form-row">
                                <div class="form-group col-md-3">
                                    {{Form::label('firstname', 'First Name')}}
                                    {{Form::text('firstname', Auth::user()->first_name, ['class' => 'form-control', 'placeholder' => 'First Name'])}}
                                    </div>
                                <div class="form-group col-md-3">
                                    {{Form::label('lastname', 'Last Name')}}
                                    {{Form::text('lastname', Auth::user()->other_names, ['class' => 'form-control', 'placeholder' => 'Last Name'])}}  
                                </div>
                                <div class="form-group col-md-3">
                                    {{Form::label('email', 'Email')}}
                                    {{Form::email('email', Auth::user()->email, ['class' => 'form-control', 'placeholder' => 'Email'])}}
                                    </div>
                                <div class="form-group col-md-3">
                                    {{Form::label('phonenumber', 'Mobile Number')}}
                                    {{Form::tel('phonenumber', Auth::user()->phone_number1, ['class' => 'form-control', 'placeholder' => 'Phone Number'])}}
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="avatar">Profile Picture</label>
                                    <input class="form-control btn-block {{ $errors->has('avatar') ? ' is-invalid' : '' }}" type="file" name="image" accept="image/jpeg, image/jpg, image/png" onchange="readURL(this);">
                                    @if ($errors->has('avatar'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                </div>


                                <div class="form-row">
                                <div class="col-md-12">
                                        <br>
                                <h5>Password Update</h5>
                                <br>
                                </div>
                                <div class="form-group col-md-4">
                                        {{Form::label('oldpass', 'Old Password')}}
                                        {{Form::password('oldpass', ['class' => 'form-control', 'placeholder' => '**********'])}}
                                    </div>
                                <div class="form-group col-md-4">
                                    {{Form::label('newpass', 'New Password')}}
                                    {{Form::password('newpass', ['class' => 'form-control', 'placeholder' => '**********'])}}
                                </div>
                                <div class="form-group col-md-4">
                                    {{Form::label('cnewpass', 'Confirm New Password')}}
                                    {{Form::password('cnewpass', ['class' => 'form-control', 'placeholder' => '**********'])}}
                                </div>
                                </div>  
                                
                                {{Form::hidden('_method','PUT')}}    
                                {{Form::submit('Update ', ['class'=>'btn btn-primary btn-block'])}}      <hr>
                                {!! Form::close() !!}
                </div>
            </div>
    </div>
    
        
    </div>

    </div>
    </div>

    <script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#avatarthumb')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>

    @endsection
