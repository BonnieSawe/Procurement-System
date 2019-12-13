@extends('layouts.dash-nav')
@section('content')
<div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                @include('inc.messages') 
                <div class="row">
                        <div class="col-md-12">
                            <div class="overview-wrap">
                                <h2 class="title-1">Departments</h2>
                                <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#addNew">
                                        <i class="fa fa-plus"></i>Add new
                                </button>
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
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($departments as $department)
                                                        <tr> 
                                                            <td style="width:100px">
                                                                    @if(!empty($department->image))
                                                                        <img  src="{{asset( $department->image )}}" alt="{{$department->image}}" class="img-responsive"/>
                                                                    @endif
                                                            </td>
                                                            <td>{{ $department->name}}</td>
                                                            <td>
                                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit-{{$department->id}}">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </button>
                                                                @if($department->active)
                                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"  data-target="#deactivate-{{$department->id}}">
                                                                        <i class="fa fa-exclamation-triangle"></i> De-activate
                                                                    </button>
                                                                @else
                                                                    
                                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"  data-target="#activate-{{$department->id}}">
                                                                        <i class="fa fa-check-o"></i>Activate
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"  data-target="#delete-{{$department->id}}">
                                                                        <i class="fa fa-close"></i> Delete
                                                                    </button>
                                                                @endif      
                                                    
                                                </td>
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
            <h4 class="modal-title"><i class="mdi mdi-format-list-bulleted menu-icon"></i> New department</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
    
        <!-- Modal body -->
        
        
        <div class="modal-body">    
            
            {!! Form::open(['action' => 'DepartmentController@create', 'method' => 'POST', 'data-parsley-validate' => '', 'files' => true]) !!}
            @csrf
                
                <div class="form-group">
                {{Form::label('name', 'Name')}}
                {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'e.g Administration','required'])}}
                </div>    

                <div class="form-group row">
                    {{ Form::label('image', 'Featured Image', array('class' => 'col-md-3 col-form-label', 'for' => 'file-input')) }}                                
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
@foreach ($departments as $department)
<div>
<div class="modal fade" id="deactivate-{{$department->id}}">
                    
        <div class="modal-dialog">
            <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-users"></i>  De-Activate Department</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
        
        
            <div class="modal-body">
                <p>Are you sure you want to de-activate <b>{{$department->name}}</b> ? </p>

                {!! Form::open(['action' => 'DepartmentController@deactivate', 'method' => 'POST']) !!}
                @csrf                               
                
                {{ Form::hidden('id', $department->id) }}
                    
                <div class="form-row">
                {{ Form::submit('De-activate', ['class' => 'btn btn-warning btn-block'])}}
                {!! Form::close() !!}
                </div>       
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="activate-{{$department->id}}">
    
        <div class="modal-dialog">
            <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-users"></i>  Activate Department</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
        
        
            <div class="modal-body">
                <p>Are you sure you want to activate <b>{{$department->name}}</b> ? </p>

                {!! Form::open(['action' => 'DepartmentController@activate', 'method' => 'POST']) !!}
                @csrf                               
                
                {{ Form::hidden('id', $department->id) }}
                    
                <div class="form-row">
                {{ Form::submit('Activate', ['class' => 'btn btn-success pull-right btn-block'])}}
                {!! Form::close() !!}
                </div>       
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="delete-{{$department->id}}">
    
        <div class="modal-dialog">
            <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-users"></i>  Delete Department</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
        
        
            <div class="modal-body">
                <p>Are you sure you want to delete <b>{{$department->name}} </b>? </p>

                {!! Form::open(['action' => 'DepartmentController@destroy', 'method' => 'POST']) !!}
                @csrf                               
                
                {{ Form::hidden('id', $department->id) }}
                    
                <div class="form-row">
                {{ Form::submit('Delete', ['class' => 'btn btn-danger pull-right btn-block'])}}
                {!! Form::close() !!}
                </div>       
            </div>
        </div>
        </div>
    </div>

        <div class="modal fade" id="edit-{{$department->id}}">

        <div class="modal-dialog">
            <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-users"></i>  Edit Category</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
        
        
            <div class="modal-body">

                {!! Form::open(['action' => 'DepartmentController@edit', 'method' => 'POST', 'data-parsley-validate' => '', 'files' => true]) !!}
                @csrf
                    
                {{ Form::hidden('id', $department->id) }}
                    <div class="form-group">
                        {{Form::label('name', 'Name')}}
                        {{Form::text('name', $department->name, ['class' => 'form-control', 'placeholder' => 'e.g FRUITS','required'])}}
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
</div>
@endforeach
</div>

@endsection