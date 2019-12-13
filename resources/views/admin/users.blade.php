@extends('layouts.dash-nav')
@section('content')
<div class="main-content">
        <div class="section__content section__content--p30">
            @include('inc.messages') 
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="overview-wrap">
                                <h2 class="title-1">Users</h2>
                                @if(Auth::user()->role->id <= 2 )
                                    <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#addNew">
                                            <i class="fa fa-plus"></i>Add new
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row m-t-30">
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                    <tr>                                                
                                                        <th>Image</th>                        
                                                        <th>Name</th>
                                                        <th>Role</th>
                                                        <th>Phone Number</th>
                                                        @if(Auth::user()->role->id <= 2 )
                                                            <th></th>
                                                        @endif
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($users as $user)
                                                        <tr> 
                                                            <td style="width:100px">
                                                                    @if(!empty($user->avatar))
                                                                        <img  src="{{asset( $user->avatar )}}" alt="{{$user->first_name}}" class="img-responsive"/>
                                                                    @endif
                                                            </td>
                                                            <td>{{ $user->first_name.' '.$user->other_names}}</td>
                                                            <td> {{$user->role->name}} </td>
                                                            <td> {{$user->phone_number1}} </td>
                                                            @if(Auth::user()->role->id <= 2 )
                                                                <td>
                                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit-{{$user->id}}">
                                                                        <i class="fa fa-edit"></i> Edit
                                                                    </button>
                                                                    @if($user->active)
                                                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"  data-target="#deactivate-{{$user->id}}">
                                                                            <i class="fa fa-exclamation-triangle"></i> De-activate
                                                                        </button>
                                                                    @else
                                                                        
                                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal"  data-target="#activate-{{$user->id}}">
                                                                            <i class="fa fa-check-o"></i>Activate
                                                                        </button>
                                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"  data-target="#delete-{{$user->id}}">
                                                                            <i class="fa fa-close"></i> Delete
                                                                        </button>
                                                                    @endif  
                                                                </td>
                                                            @endif      

                                                    </tr>
                                                @endforeach
                                
                                                </tbody>
                                        </table>
                                    </div>
                                <!-- END DATA TABLE-->
                            </div>
                    </div>
            </div>
        </div>
</div>
</main>

<div>
<!-- New Item Modal -->
<div class="modal fade" id="addNew">
    <div class="modal-dialog">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-user"></i> New user</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
    
        <!-- Modal body -->
        
        
        <div class="modal-body">    
            
            {!! Form::open(['action' => 'UserController@store', 'method' => 'POST', 'data-parsley-validate' => '', 'files' => true]) !!}
            @csrf
                <div class="form-group">
                    {{Form::label('firstname', 'First Name')}}
                    {{Form::text('firstname', '', ['class' => 'form-control', 'placeholder' => 'First Name'])}}
                </div>
                <div class="form-group">
                    {{Form::label('lastname', 'Last Name')}}
                    {{Form::text('lastname', '', ['class' => 'form-control', 'placeholder' => 'Last Name'])}}  
                </div>
                <div class="form-group">
                    {{Form::label('email', 'Email')}}
                    {{Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Email'])}}
                    </div>
                <div class="form-group">
                    {{Form::label('phonenumber', 'Mobile Number')}}
                    {{Form::tel('phonenumber', '', ['class' => 'form-control', 'placeholder' => 'Phone Number'])}}
                </div>
                <div class="form-group">
                    <label for="role_id">Role</label>
                    <select  name="role_id" class="form-control" required>                                                                                
                        <option disabled selected value="0">None</option>
                            @foreach ($roles as $role) 
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                    </select>
                </div>
                <div class="form-group row">
                    {{ Form::label('image', 'Profile Picture', array('class' => 'col-md-3 col-form-label', 'for' => 'file-input')) }}                                
                    <div class="col-md-9">
                        {{ Form::file('image', ['id' => 'file-input']) }}                                   
                    </div>
                </div>                                 
                
                <div class="form-row">
                {{Form::submit('Create', ['class' => 'btn btn-primary btn-block'])}}
                </div>

            {!! Form::close() !!}
            
            </div>
        </div>
    </div>
</div>
@foreach ($users as $user)
<div>
<div class="modal fade" id="deactivate-{{$user->id}}">
                    
        <div class="modal-dialog">
            <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-users"></i>  De-Activate User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
        
        
            <div class="modal-body">
                <p>Are you sure you want to de-activate <b>{{$user->first_name.' '.$user->other_names}}</b> ? </p>

                {!! Form::open(['action' => 'UserController@deactivate', 'method' => 'POST']) !!}
                @csrf                               
                
                {{ Form::hidden('id', $user->id) }}
                    
                <div class="form-row">
                {{ Form::submit('De-activate', ['class' => 'btn btn-warning btn-block'])}}
                {!! Form::close() !!}
                </div>       
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="activate-{{$user->id}}">
    
        <div class="modal-dialog">
            <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-users"></i>  Activate Post</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
        
        
            <div class="modal-body">
                <p>Are you sure you want to activate <b>{{$user->first_name.' '.$user->other_names}}</b> ? </p>

                {!! Form::open(['action' => 'UserController@activate', 'method' => 'POST']) !!}
                @csrf                               
                
                {{ Form::hidden('id', $user->id) }}
                    
                <div class="form-row">
                {{ Form::submit('Activate', ['class' => 'btn btn-success pull-right btn-block'])}}
                {!! Form::close() !!}
                </div>       
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="delete-{{$user->id}}">
    
        <div class="modal-dialog">
            <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-users"></i>  Delete Post</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
        
        
            <div class="modal-body">
                <p>Are you sure you want to delete <b>{{$user->first_name.' '.$user->other_names}} </b>? </p>

                {!! Form::open(['action' => 'UserController@delete', 'method' => 'POST']) !!}
                @csrf                               
                
                {{ Form::hidden('id', $user->id) }}
                    
                <div class="form-row">
                {{ Form::submit('Delete', ['class' => 'btn btn-danger pull-right btn-block'])}}
                {!! Form::close() !!}
                </div>       
            </div>
        </div>
        </div>
    </div>

        <div class="modal fade" id="edit-{{$user->id}}">

        <div class="modal-dialog">
            <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-users"></i>  Edit User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
        
        
            <div class="modal-body">

                {!! Form::open(['action' => ['UserController@editUser', $user->id], 'method' => 'POST', 'data-parsley-validate' => '', 'files' => true]) !!}
                @csrf
                    
                {{ Form::hidden('id', $user->id) }}                    
                    <div class="form-group">
                        {{Form::label('firstname', 'First Name')}}
                        {{Form::text('firstname', $user->first_name, ['class' => 'form-control', 'placeholder' => 'First Name'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('lastname', 'Last Name')}}
                        {{Form::text('lastname', $user->other_names, ['class' => 'form-control', 'placeholder' => 'Last Name'])}}  
                    </div>
                    <div class="form-group">
                        {{Form::label('email', 'Email')}}
                        {{Form::email('email', $user->email, ['class' => 'form-control', 'placeholder' => 'Email'])}}
                        </div>
                    <div class="form-group">
                        {{Form::label('phonenumber', 'Mobile Number')}}
                        {{Form::tel('phonenumber', $user->phone_number1, ['class' => 'form-control', 'placeholder' => 'Phone Number'])}}
                    </div>
                    <div class="form-group">
                            <label for="role_id">Role</label>
                            <select  name="role_id" class="form-control" required>                                                                                
                                <option value="{{$user->role->id}}">{{$user->role->name}}</option>
                                    @foreach ($roles as $role) 
                                    @if($role->name !== $user->role->name)                                 
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endif
                                    @endforeach
                            </select>
                        </div>  

                    <div class="form-group row">
                        {{ Form::label('image', 'Featured Image', array('class' => 'col-md-3 col-form-label', 'for' => 'file-input')) }}                                
                        <div class="col-md-9">
                            {{ Form::file('image', ['id' => 'file-input']) }}                                   
                        </div>
                    </div> 
                    
                    <div class="form-row">
                        {{Form::submit('Update', ['class' => 'btn btn-primary btn-block'])}}
                    </div>

                {!! Form::close() !!}

                </div>
            </div>
            </div>
    </div>
    @endforeach
</div>
@endsection