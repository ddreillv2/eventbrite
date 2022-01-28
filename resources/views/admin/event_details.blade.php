@extends('layouts.default')

@section('styles')
<style>
    .profile-card:after {
        display: none;
    }

    .profile-card:before {
        display: none;
    }

    .pro-content {
        margin-top: -35px;
    }

    .profile-box {
        padding-bottom: 140px;
    }
</style>
@endsection

@section('content')

@if($has_event)

<div class="content-top">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between py-3">
            <div class="navbar-breadcrumb">
                <h2 class="mb-1">Event Details</h2>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid container">
    <div class="row">
        <div class="col-lg-4">

            @if($eventInfo['status'] == "started")
            <div class="alert alert-success" role="alert">
                <div class="iq-alert-icon">
                    <i class="ri-information-line"></i>
                </div>
                <div class="iq-alert-text">
                    <p class="font-weight-600 mb-0">Ongoing</p>
                </div>
            </div>
            @elseif($eventInfo['status'] == "ended" || $eventInfo['status'] == "completed")
            <div class="alert alert-secondary" role="alert">
                <div class="iq-alert-icon">
                    <i class="ri-information-line"></i>
                </div>
                <div class="iq-alert-text">
                    <p class="font-weight-600 mb-0">Ended</p>
                    <p class="font-size-14 mb-0">This event has been ended</p>
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{$eventInfo['name']['text']}}</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-icon mr-3">
                            <i class="las la-calendar-day"></i>
                        </div>
                        <p class="mb-0">{{date('D, F d, Y g:i A', strtotime($eventInfo['start']['local']))}}</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="p-icon mr-3">
                            <i class="las la-map-marker-alt"></i>
                        </div>
                        <p class="mb-0">{{$eventInfo['location']}}</p>
                    </div>
                </div>
                @if($eventInfo['registration_status'] == "NOT_YET_AVAILABLE")
                <div class="card-footer text-muted">
                    <p class="mb-0 font-weight-500 text-center">Registration starts on <br>{{ date("F d \\a\\t h:iA", strtotime($eventInfo['registration_date'])) }}</p>
                </div>

                @elseif($eventInfo['registration_status'] == "AVAILABLE")
                <div class="card-footer">
                    <a href="" class="btn btn-success rounded-pill btn-block py-2 my-2"><i class="las la-ticket-alt"></i>Register</a>
                </div>

                @endif
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-block mb-5">
                @isset($eventInfo['logo']['url'])
                <img src="{{$eventInfo['logo']['url']}}" class="card-img-top" alt="#">
                @endisset
                <div class="card-body px-5">
                    {!! $eventInfo['description']['html'] !!}
                </div>

            </div>
        </div>
    </div>
</div>

@else()
<div class="container">
    <div class="row no-gutters height-self-center">
        <div class="col-sm-12 text-center align-self-center">
            <div class="iq-error position-relative">
                <h2 class="mb-0 mt-4">Oops! Something went wrong</h2>
                <p>Unable to identify the event</p>
                <a class="btn btn-primary d-inline-flex align-items-center mt-3" href="{{url('/events')}}">Back to Events List</a>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')



@endsection