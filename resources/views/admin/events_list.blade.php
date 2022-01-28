@extends('layouts.default')


@section('styles')
<style>
    .list-action .badge {
        background-color: #f5f6fa;
        color: #535f6b;
        font-size: 20px;
        padding-top: 8px;
    }
</style>
@endsection
@section('content')

<div class="content-top">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between py-3">
            <div class="navbar-breadcrumb">
                <h1 class="mb-1">Events</h1>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="event-content">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                    <ul class="d-flex nav nav-pills text-center schedule-tab" id="schedule-pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" data-toggle="pill" href="#events_all" role="tab" aria-selected="false">All</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#events_upcoming" role="tab" aria-selected="true">Upcoming</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#events_past" role="tab" aria-selected="false">Past</a>
                        </li>
                    </ul>
                </div>
                <div class="schedule-content">
                    <div id="events_all" class="tab-pane fade active show">
                        <div class="row">
                            @foreach ($events['events'] as $event)
                            <div class="col-lg-12">
                                <div class="card card-block card-stretch">
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div class="date mr-3">
                                                    <h4 class="text-info">{{date("d", strtotime($event['start']['local'])) }}</h4>
                                                    <h5 class="text-info">{{date("M", strtotime($event['start']['local']))}}</h5>
                                                </div>
                                                <div class="border-left-event pl-3">
                                                    <div class="media align-items-top">
                                                        <h5 class="mb-3">{{$event['name']['text']}}</h5>
                                                        @if($event['status'] == "live")
                                                        <div class="badge badge-success ml-3 badge-color">Upcoming</div>
                                                        @elseif($event['status'] == "started")
                                                        <div class="badge badge-warning ml-3 badge-color">Ongoing</div>
                                                        @endif
                                                    </div>
                                                    <div class="media align-items-center">
                                                        <p class="mb-0 pr-3"><i class="las la-clock mr-2 text-info"></i>{{date("l, F d, Y \\a\\t h:iA",strtotime($event['start']['local']))}}</p>
                                                        <p class="mb-0"><i class="las la-map-marker mr-2 text-info"></i>{{ $event['location']}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center list-action mt-lg-0 mt-2">

                                                <div class="badge mr-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Action">
                                                    <div class="dropdown">
                                                        <div class="action-item" id="moreOptions1" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                                            <i class="las la-ellipsis-v"></i>
                                                        </div>
                                                        <div class="dropdown-menu" aria-labelledby="moreOptions1">
                                                            <a href="{{url('/event'). '/' . $event['id']}}" class="dropdown-item" href="#">More details</a>
                                                        </div>
                                                    </div>

                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div id="events_upcoming" class="tab-pane fade">
                        <div class="row">
                            @foreach ($events['events'] as $event)

                            @if($event['status'] == "live" || $event['status'] == "started")

                            <div class="col-lg-4 col-md-6">
                                <div class="card card-block card-stretch card-height">
                                    <div class="card-body rounded event-detail event-detail1">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div>
                                                <h1 class="text-info">{{date("d", strtotime($event['start']['local'])) }}</h1>
                                                <h5 class="text-info">{{date("M", strtotime($event['start']['local']))}}</h5>
                                            </div>
                                        </div>
                                        <h4 class="my-2">{{ $event['name']['text'] }}</h4>
                                        <p class="mb-3 card-description">{{$event['summary']}}</p>
                                        <p class="mb-2 text-info"><i class="las la-clock mr-3"></i>{{date("l, F d, Y \\a\\t h:iA",strtotime($event['start']['local']))}}</p>
                                        <p class="mb-0 text-info"><i class="las la-map-marker mr-3"></i>{{ $event['location']}}</p>
                                        <div class="mt-3">
                                            <a href="{{url('/event'). '/' . $event['id']}}" class="btn btn-outline-secondary btn-block">More details</a>

                                            @if($event['registration_status'] == "NOT_YET_AVAILABLE")
                                                <p class="mt-3 font-weight-600 text-center">Registration starts on <br>{{ date("F d \\a\\t h:iA", strtotime($event['registration_date'])) }}</p>
                                            @elseif($event['registration_status'] == "AVAILABLE")
                                                <a href="" class="btn btn-success rounded-pill mt-3 btn-block"><i class="las la-ticket-alt"></i>Register</a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <div id="events_past" class="tab-pane fade">
                        <div class="row">
                            @foreach ($events['events'] as $event)

                            @if($event['status'] == "completed" || $event['status'] == "ended")

                            <div class="col-lg-4 col-md-6">
                                <div class="card card-block card-stretch card-height">
                                    <div class="card-body rounded event-detail event-detail1">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div>
                                                <h1 class="text-info">{{date("d", strtotime($event['start']['local'])) }}</h1>
                                                <h5 class="text-info">{{date("M", strtotime($event['start']['local']))}}</h5>
                                            </div>
                                        </div>
                                        <h4 class="my-2">{{ $event['name']['text'] }}</h4>
                                        <p class="mb-3 card-description">{{$event['summary']}}</p>
                                        <p class="mb-2 text-info"><i class="las la-clock mr-3"></i>{{date("l, F d, Y \\a\\t h:iA",strtotime($event['start']['local']))}}</p>
                                        <p class="mb-0 text-info"><i class="las la-map-marker mr-3"></i>{{ $event['location']}}</p>
                                        <div class="mt-3">
                                            <a href="{{url('/event'). '/' . $event['id']}}" class="btn btn-outline-secondary btn-block">More details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="popup text-left" id="popup">
                    <h4 class="mb-3">Add Action</h4>
                    <div class="content create-workform">
                        <div class="form-group">
                            <h6 class="form-label mb-3">Copy Your Link</h6>
                            <div class="input-group">
                                <input type="text" class="form-control" readonly value="calendly.com/rickoshea1234">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2"><i class="las la-link"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h6 class="form-label mb-3">Email Your Link</h6>
                            <div class="input-group">
                                <input type="text" class="form-control" readonly value="calendly.com/rickoshea1234">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon3"><i class="las la-envelope"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h6 class="form-label mb-3">Add to Your Website</h6>
                            <div class="input-group">
                                <input type="text" class="form-control" readonly value="calendly.com/rickoshea1234">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon4"><i class="las la-code"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <div class="d-flex flex-wrap align-items-ceter justify-content-center">
                                <button type="submit" data-dismiss="modal" class="btn btn-primary mr-4">Cancel</button>
                                <button type="submit" data-dismiss="modal" class="btn btn-outline-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade create-workform" id="create-event" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="popup text-left">
                    <h4 class="mb-3">Create a Workflow</h4>
                    <div class="mb-3">
                        <h5>When this happens</h5>
                        <div class="content">
                            <div class="form-group mb-0">
                                <select name="type" class="selectpicker form-control" data-style="py-0">
                                    <option>Select..</option>
                                    <option>New event is scheduled</option>
                                    <option>Before event starts</option>
                                    <option>Event starts</option>
                                    <option>Event ends</option>
                                    <option>Event is canceled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h5 class="mb-3">Do this</h5>
                        <div class="form-group  mb-0">
                            <select name="type" class="selectpicker form-control" data-style="py-0">
                                <option>Select..</option>
                                <option>Send email to invitee</option>
                                <option>Send email to host</option>
                                <option>Send text to invitee</option>
                                <option>Send text to host</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex flex-wrap align-items-ceter justify-content-center">
                            <div class="btn btn-primary mr-4" data-dismiss="modal">Cancel</div>
                            <div class="btn btn-outline-primary" data-dismiss="modal">Save</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    function refresh_list_events() {

        axios({
            method: "GET",
            url: "{{ url('/events/retrieveAll') }}",
            timeout: "{{ $axios_timeout }}"
        }).then(function(respond) {
            if (respond.status == 200) {
                data = respond.data.events;

                $(".tab-pane .row").empty();

                for (let i = 0; i < data.length; i++) {
                    startTime = moment(data[i].start.local);
                    endTime = moment(data[i].end.local);
                    eventTime = startTime.format("dddd, MMMM DD, Y [at] hh:mmA");

                    eventStatus = data[i].status;
                    if (eventStatus == "completed" || eventStatus == "ended") {

                        eventAllStatus = '';
                        $(`<div class="col-lg-4 col-md-6">
                            <div class="card card-block card-stretch card-height">
                                <div class="card-body rounded event-detail event-detail1">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div>
                                            <h1 class="text-info">${startTime.format('D')}</h1>
                                            <h5 class="text-info">${endTime.format('MMM')}</h5>
                                        </div>
                                    </div>
                                    <h4 class="my-2">${data[i].name.text}</h4>
                                    <p class="mb-3 card-description">${data[i].summary}</p>
                                    <p class="mb-2 text-info"><i class="las la-clock mr-3"></i>${eventTime}</p>
                                    <p class="mb-0 text-info"><i class="las la-map-marker mr-3"></i>${data[i].location}</p>
                                    <div class="mt-3">
                                        <a href="{{url('/event')}}/${data[i]['id']}" class="btn btn-outline-secondary btn-block">More details</a>
                                    </div>
                                </div>
                            </div>
                        </div>`).appendTo("#events_past .row");
                    } else if (eventStatus == "live" || eventStatus == "started") {

                        eventAllStatus = (eventStatus == "live") ? '<div class="badge badge-success ml-3 badge-color">Upcoming</div>' : '<div class="badge badge-warning ml-3 badge-color">Ongoing</div>';
                        $(`<div class="col-lg-4 col-md-6">
                            <div class="card card-block card-stretch card-height">
                                <div class="card-body rounded event-detail event-detail1">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div>
                                            <h1 class="text-info">${startTime.format('D')}</h1>
                                            <h5 class="text-info">${endTime.format('MMM')}</h5>
                                        </div>
                                    </div>
                                    <h4 class="my-2">${data[i].name.text}</h4>
                                    <p class="mb-3 card-description">${data[i].summary}</p>
                                    <p class="mb-2 text-info"><i class="las la-clock mr-3"></i>${eventTime}</p>
                                    <p class="mb-0 text-info"><i class="las la-map-marker mr-3"></i>${data[i].location}</p>
                                    <div class="mt-3">
                                        <a href="{{url('/event')}}/${data[i]['id']}" class="btn btn-outline-secondary btn-block">More details</a>
                                        <a href="" class="btn btn-success rounded-pill mt-3 btn-block"><i class="las la-ticket-alt"></i>Register</a>
                                    </div>
                                </div>
                            </div>
                        </div>`).appendTo("#events_upcoming .row");
                    }

                    $(`<div class="col-lg-12">
                        <div class="card card-block card-stretch">
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center justify-content-between">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <div class="date mr-3">
                                            <h4 class="text-info">${startTime.format('D')}</h4>
                                            <h5 class="text-info">${endTime.format('MMM')}</h5>
                                        </div>
                                        <div class="border-left-event pl-3">
                                            <div class="media align-items-top">
                                                <h5 class="mb-3">${data[i].name.text}</h5>
                                                ${eventAllStatus}
                                            </div>
                                            <div class="media align-items-center">
                                                <p class="mb-0 pr-3"><i class="las la-clock mr-2 text-info"></i>${eventTime}</p>
                                                <p class="mb-0"><i class="las la-map-marker mr-2 text-info"></i>${data[i].location}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center list-action mt-lg-0 mt-2">

                                        <div class="badge mr-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Action">
                                        <div class="dropdown">
                                            <div class="action-item" id="moreOptions1" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                            <i class="las la-ellipsis-v"></i>
                                            </div>
                                            <div class="dropdown-menu" aria-labelledby="moreOptions1" style="">
                                                <a href="{{url('/event')}}/${data[i]['id']}" class="dropdown-item" href="#">More details</a>
                                            </div>
                                        </div>

                                        </div>
                                    
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`).appendTo("#events_all .row");

                }
            } else {
                display_modal_error("{{ __('modal.error') }}");
            }
        }).catch(function(error) {
            display_axios_error(error);
        });
    };
</script>

@endsection