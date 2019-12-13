@extends('layouts.dash-nav')
@section('content')
<div class="main-content">
        <div class="section__content section__content--p30">
            @include('inc.messages') 
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="overview-wrap">
                                <h2 class="title-1">Quotes</h2>
                                @if (Auth::user()->role->id <= 2)
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
                                                    <th>Amount</th>
                                                    <th>Desc</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tr>
                                        </thead>                                        
                                        <tbody>
                                            @foreach($quotes as $quote)
                                                <tr>      
                                                    @if (count($quote->quoteItems))
                                                        <td>{{ 'Ksh '.number_format($quote->quoteItems->sum('price'))}}</td>
                                                    @else
                                                        <td>---</td>
                                                    @endif                                      
                                                    <td>{{ substr(strip_tags($quote->desc), 0, 50) }}{{ strlen(strip_tags($quote->desc)) > 50 ? "..." : ""}}</td>
                                                    <td>{{ date('M j, Y', strtotime($quote->created_at)) }}</td>
                                                    @if($quote->status == 0)
                                                        <td class="text-info"><i class="fa fa-spinner"> Pending</td>
                                                    @elseif($quote->status == 1)
                                                        <td class="text-danger"><i class="fa fa-close"> Declined</td>
                                                    @elseif($quote->status == 2)
                                                        <td class="text-success"><i class="fa fa-check-circle"></i> Approved</td>
                                                    {{-- @elseif($quote->status == 0)
                                                        <td></td> --}}
                                                    @endif
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">                                                    
                                                                {{-- <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-{{$quote->id}}">Edit</a>                                         --}}
                                                                @if (Auth::user()->role->id <= 2)
                                                                    @if($quote->status == 0)
                                                                        <a class="dropdown-item" href="#" data-toggle="modal"  data-target="#decline-{{$quote->id}}">Decline</a>
                                                                        <a class="dropdown-item" href="#" data-toggle="modal"  data-target="#approve-{{$quote->id}}">Approve</a>
                                                                    {{-- @else
                                                                        <a class="dropdown-item" href="#" data-toggle="modal"  data-target="#bids-{{$quote->id}}">Bids</a> --}}
                                                                    @endif
                                                                    <a class="dropdown-item" href="#" data-toggle="modal"  data-target="#delete-{{$quote->id}}">Delete</a>
                                                                @endif
                                                                @if (Auth::user()->role->id == 3 && $quote->status == 2)
                                                                    <a class="dropdown-item" href="#" data-toggle="modal"  data-target="#bid-{{$quote->id}}">Bid</a>
                                                                @endif
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
    <div class="modal-dialog modal-lg">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title"><i class="mdi mdi-format-list-bulleted menu-icon"></i> New Quote</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
    
        <!-- Modal body -->
        
        
        <div class="modal-body">    
            
            {!! Form::open(['action' => 'QuoteController@create', 'method' => 'POST', 'data-parsley-validate' => '', 'files' => true]) !!}
            @csrf
                
                <div class="form-group">
                    {{Form::label('department_id', 'Department')}}
                    <select  name="department_id" class="form-control select2" required>                                        
                        <option disabled selected value="0">--Select--</option>
                        @foreach ($departments as $department)                                  
                            <option value="{{$department->id}}">{{$department->name}}</option>
                        @endforeach
                    </select>
                </div>    

                <div class="form-group">
                    {{Form::label('description', 'Description')}}
                    {{Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => '...','rows' => '5', ''])}}
                </div> 
                
                <br>
                <h4 class="text-center">Items</h4>  
                <hr>
                @php
                    $others= 0;
                @endphp
                @while ($others <5)
                    <div class="form-row">
                        <div class="col-md-4">
                            {{Form::label('qty', 'Quantity')}}
                            {{Form::number('qty[]', '', ['class' => 'form-control'])}}   
                        </div>                                
                        <div class="col-md-4">
                            {{Form::label('unit', 'Unit')}}
                            {{Form::text('unit[]', '', ['class' => 'form-control'])}}   
                        </div>                        
                        <div class="col-md-4">
                            {{Form::label('price', 'Unit Price')}}
                            {{Form::number('price[]', '', ['class' => 'form-control'])}} 
                        </div>                        
                        <div class="col-md-12">
                            {{Form::label('desc', 'Description')}}
                            {{Form::textarea('desc[]', '', ['class' => 'form-control', 'placeholder' => '...', 'rows' => '3'])}} 
                        </div>
                    </div>  
                    <hr>                        
                    @php
                        $others++;           
                    @endphp
                @endwhile  
                <br>
                
                <div class="form-row">
                    {{Form::submit('Create', ['class' => 'btn btn-primary btn-block'])}}
                </div>

            {!! Form::close() !!}
            
            </div>
        </div>
    </div>
</div>

@foreach ($quotes as $quote)
    <!-- New Item Modal -->
    <div class="modal fade" id="bid-{{$quote->id}}">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="mdi mdi-format-list-bulleted menu-icon"></i> New Bid</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        
            <!-- Modal body -->
            
            
            <div class="modal-body">    
                
                {!! Form::open(['action' => 'BidController@create', 'method' => 'POST', 'data-parsley-validate' => '', 'files' => true]) !!}
                @csrf
                    
                    <div class="form-group">
                        {{Form::label('amount', 'Amount')}}
                        {{Form::number('amount', '', ['class' => 'form-control', 'placeholder' => '...', 'required'])}}
                    </div>    

                    <div class="form-group">
                        {{Form::label('message', 'Message')}}
                        {{Form::textarea('message', '', ['class' => 'form-control', 'placeholder' => '...','rows' => '5', ''])}}
                    </div> 
                    <br>
                    {{ Form::hidden('quote_id', $quote->id) }}

                    <div class="form-row">
                        {{Form::submit('Create', ['class' => 'btn btn-primary btn-block'])}}
                    </div>

                {!! Form::close() !!}
                
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="decline-{{$quote->id}}">
                                                        
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-quote-left"></i>  Decline quote</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->


                <div class="modal-body">
                    <p>Are you sure you want to Decline this Quote</b> ? </p>

                    {!! Form::open(['action' => 'QuoteController@decline', 'method' => 'POST']) !!}
                    @csrf                               
                    
                        {{ Form::hidden('id', $quote->id) }}
                        
                    <div class="form-row">
                        {{ Form::submit('Decline', ['class' => 'btn btn-warning btn-block'])}}
                        {!! Form::close() !!}
                    </div>       
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="approve-{{$quote->id}}">

        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-quote-left"></i>  Approve Quote</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->


                <div class="modal-body">
                    <p>Are you sure you want to approve this Quote ? </p>

                    {!! Form::open(['action' => 'QuoteController@approve', 'method' => 'POST']) !!}
                    @csrf                               
                    
                        {{ Form::hidden('id', $quote->id) }}
                        
                    <div class="form-row">
                        {{ Form::submit('Approve', ['class' => 'btn btn-success pull-right btn-block'])}}
                        {!! Form::close() !!}
                    </div>       
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-{{$quote->id}}">

        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-quote-left"></i>  Delete quote</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->


                <div class="modal-body">
                    <p>Are you sure you want to delete this Quote? </p>

                    {!! Form::open(['action' => 'QuoteController@destroy', 'method' => 'POST']) !!}
                    @csrf                               
                    
                        {{ Form::hidden('id', $quote->id) }}
                        
                    <div class="form-row">
                        {{ Form::submit('Delete', ['class' => 'btn btn-danger pull-right btn-block'])}}
                        {!! Form::close() !!}
                    </div>       
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection