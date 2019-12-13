@extends('layouts.dash-nav')
@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">overview</h2>
                        {{-- <button class="au-btn au-btn-icon au-btn--blue">
                            <i class="zmdi zmdi-plus"></i>add item</button> --}}
                    </div>
                </div>
            </div>
            <div class="row m-t-25">
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c1">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="fa fa-table"></i>
                                </div>
                                <div class="text">
                                    <h2>{{count($quotes)}}</h2>
                                    <span>Quotes</span>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart1"></canvas>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c2">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="fa fa-quote-left"></i>
                                </div>
                                <div class="text">
                                    <h2>{{count($bids)}}</h2>
                                    <span>Bids</span>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart2"></canvas>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c3">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-chart"></i>
                                </div>
                                <div class="text">
                                    <h2>{{count($suppliers)}}</h2>
                                    <span>Suppliers</span>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart4"></canvas>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c4">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="text">
                                    <h2>{{count($users)}}</h2>
                                    <span>users</span>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart3"></canvas>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection