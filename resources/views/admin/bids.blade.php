@extends('layouts.dash-nav')
@section('content')
<div class="main-content">
        <div class="section__content section__content--p30">
            @include('inc.messages') 
            <div class="container-fluid">
                <div class="row">
                        <div class="col-md-12">
                            <div class="overview-wrap">
                                <h2 class="title-1">Bids</h2>
                                {{-- <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#addNew">
                                        <i class="fa fa-plus"></i>Add new
                                </button> --}}
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
                                                <th>Date</th>                        
                                                <th>Supplier</th>
                                                <th>Amount</th>
                                                <th>Message</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($bids as $bid)
                                                <tr>
                                                    <td>{{ date('M j, Y', strtotime($bid->created_at)) }}</td>
                                                    <td>{{ $bid->Supplier->first_name.' '.$bid->Supplier->other_names}}</td>
                                                    <td>{{ 'Ksh. '. number_format($bid->amount)}}</td>
                                                    <td>{{ substr(strip_tags($bid->message), 0, 50) }}{{ strlen(strip_tags($bid->message)) > 50 ? "..." : ""}}</td>
                                                    @if($bid->status == 0)
                                                        <td class="text-info"><i class="fa fa-spinner"> Pending</td>
                                                    @elseif($bid->status == 1)
                                                        <td class="text-danger"><i class="fa fa-close"> Denied</td>
                                                    @elseif($bid->status == 2)
                                                        <td class="text-success"><i class="fa fa-check-circle"></i> Awarded</td>
                                                    @endif
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">                                                    
                                                                {{-- <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-{{$bid->id}}">Edit</a>                                         --}}
                                                                @if (Auth::user()->role->id <= 2)
                                                                    @if ($bid->status == 0)
                                                                        <a class="dropdown-item" href="#" data-toggle="modal"  data-target="#deny-{{$bid->id}}">Deny</a>
                                                                        <a class="dropdown-item" href="#" data-toggle="modal"  data-target="#award-{{$bid->id}}">Award</a>
                                                                    @endif
                                                                    @if ($bid->status == 1)
                                                                        <a class="dropdown-item" href="#" data-toggle="modal"  data-target="#comments-{{$bid->id}}">Comments</a>
                                                                    @endif
                                                                        <a class="dropdown-item" href="#" data-toggle="modal"  data-target="#delete-{{$bid->id}}">Delete</a>
                                                                @endif
                                                                {{-- @if (Auth::user()->role->id == 3 && $bid->status == 2)
                                                                    <a class="dropdown-item" href="#" data-toggle="modal"  data-target="#bid-{{$bid->id}}">Bid</a>
                                                                @endif --}}
                                                            </div>
                                                        </div>
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
            <h4 class="modal-title"><i class="mdi mdi-format-list-bulleted menu-icon"></i> New bid</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
    
        <!-- Modal body -->
        
        
        <div class="modal-body">    
            
            {!! Form::open(['action' => 'BidController@create', 'method' => 'POST', 'data-parsley-validate' => '', 'files' => true]) !!}
            @csrf
                
                <div class="form-group">
                {{Form::label('name', 'Name')}}
                {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'e.g Sermons','required'])}}
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
@foreach ($bids as $bid)
<div>
    <div class="modal fade" id="comments-{{$bid->id}}">
                
            <div class="modal-dialog">
                <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-comments"></i>  Comments</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
            
            
                <div class="modal-body">
                    <div class="col-md-12">
                        <!-- DATA TABLE-->
                        <div class="table-responsive m-b-40">
                            <table class="table table-borderless table-data3">
                                <thead>
                                    <tr>                                                
                                        <th>Date</th>                        
                                        <th>Comment</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bid->comments as $comment)
                                            <tr>
                                                <td>{{ date('M j, Y', strtotime($comment->created_at)) }}</td>
                                                <td>{{ substr(strip_tags($comment->comment), 0, 100) }}{{ strlen(strip_tags($comment->comment)) > 100 ? "..." : ""}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
<div class="modal fade" id="deny-{{$bid->id}}">
                    
        <div class="modal-dialog">
            <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-users"></i>  Deny Bid</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
        
        
            <div class="modal-body">
                <p>Are you sure you want to deny <b>Bid</b> ? </p>

                {!! Form::open(['action' => 'BidController@deny', 'method' => 'POST']) !!}
                @csrf                               
                
                {{ Form::hidden('id', $bid->id) }}
                <br>
                <div class="form-group">
                    {{Form::label('comment', 'Comment')}}
                    {{Form::textarea('comment', '', ['class' => 'form-control', 'placeholder' => '...','rows' => '5', 'required'])}}
                </div> 
                    
                <div class="form-row">
                {{ Form::submit('Deny', ['class' => 'btn btn-warning btn-block'])}}
                {!! Form::close() !!}
                </div>       
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="award-{{$bid->id}}">
    
        <div class="modal-dialog">
            <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-users"></i>  Award Bid</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
        
        
            <div class="modal-body">
                <p>Are you sure you want to award <b>bid</b> ? </p>

                {!! Form::open(['action' => 'BidController@award', 'method' => 'POST']) !!}
                @csrf                               
                
                {{ Form::hidden('id', $bid->id) }}
                    
                <div class="form-row">
                {{ Form::submit('Award', ['class' => 'btn btn-success pull-right btn-block'])}}
                {!! Form::close() !!}
                </div>       
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="delete-{{$bid->id}}">
    
        <div class="modal-dialog">
            <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-users"></i>  Delete Bid</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
        
        
            <div class="modal-body">
                <p>Are you sure you want to delete <b>{{$bid->name}} </b>? </p>

                {!! Form::open(['action' => 'BidController@destroy', 'method' => 'POST']) !!}
                @csrf                               
                
                {{ Form::hidden('id', $bid->id) }}
                    
                <div class="form-row">
                {{ Form::submit('Delete', ['class' => 'btn btn-danger pull-right btn-block'])}}
                {!! Form::close() !!}
                </div>       
            </div>
        </div>
        </div>
    </div>

        <div class="modal fade" id="edit-{{$bid->id}}">

        <div class="modal-dialog">
            <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-users"></i>  Edit bid</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
        
        
            <div class="modal-body">

                {!! Form::open(['action' => 'BidController@edit', 'method' => 'POST', 'data-parsley-validate' => '', 'files' => true]) !!}
                @csrf
                    
                {{ Form::hidden('id', $bid->id) }}
                    <div class="form-group">
                        {{Form::label('name', 'Name')}}
                        {{Form::text('name', $bid->name, ['class' => 'form-control', 'placeholder' => 'e.g FRUITS','required'])}}
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