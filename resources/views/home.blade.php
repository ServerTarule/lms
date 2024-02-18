@extends('layout.app')
@section('title','CRM Admin Dashboard')
@section('subtitle','Very detailed & featured admin')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <div id="cardbox1">
                <div class="statistic-box">
                    <div class="counter-number pull-right">
                        <span class="count-number">{{$leadsCount}}</span>
                        <span class="slight"><i class="fa fa-play fa-rotate-270"> </i>
                     </span>
                    </div>
                    <h3>Total Leads</h3>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <div id="cardbox1">
                <a href="/leads/assigned"> 
                    <div class="statistic-box">
                        <div class="counter-number pull-right">
                            <span class="count-number">{{$userAssignedLeadsCount}}</span>
                            <span class="slight"><i class="fa fa-play fa-rotate-270"> </i>
                        </span>
                        </div>
                        <h3>Assigned Leads</h3>
                    </div>
                </a>
            </div>
        </div>
        {{-- <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <div id="cardbox2">
                <div class="statistic-box">
                    <div class="counter-number pull-right">
                        <span class="count-number"></span>
                        <span class="slight"><i class="fa fa-play fa-rotate-270"> </i>
                     </span>
                    </div>
                    <h3>SMS/Email</h3>
                </div>
            </div>
        </div> --}}
        {{-- <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <div id="cardbox3">
                <div class="statistic-box">
                    <div class="counter-number pull-right">
                        <span class="count-number"></span>
                        <span class="slight"><i class="fa fa-play fa-rotate-270"> </i>
                     </span>
                    </div>
                    <h3>Support Hot Lead</h3>
                </div>
            </div>
        </div> --}}
        {{-- <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <div id="cardbox4">
                <div class="statistic-box">
                    <div class="counter-number pull-right">
                        <span class="count-number"></span>
                        <span class="slight"><i class="fa fa-play fa-rotate-270"> </i>
                     </span>
                    </div>
                    <h3>Hot Leads</h3>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
