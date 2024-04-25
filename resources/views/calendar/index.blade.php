@extends('layouts.master-layout')
@section('current-page')
    Calendar
@endsection
@section('extra-styles')
    <link rel="stylesheet" href="/css/nprogress.css">
    <link href="/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/fullcalendar/main.min.css')}}">
    <link href="/css/parsley.css" rel="stylesheet" type="text/css" />
    <style>
        a[style*="background-color: grey"] > * {
            background: grey !important;
        }
       /* .fc .fc-view-container .fc-view table .fc-body .fc-widget-content .fc-day-grid-container .fc-day-grid .fc-row .fc-content-skeleton table .fc-event-container .fc-day-grid-event.fc-event{
            padding: 9px 16px;
            border-radius: 20px 20px 20px 0px;
        }
        .fc-title{
            color:white !important;
        }
        .fc-time{
            color: white !important;
        }

        .nav-pills .nav-link.active, .nav-pills .show > .nav-link{
            background: #9DCB5C !important;
        }
        .nav-pills .nav-link{
            border-radius: 0px !important;
        }
        .dropdown-menu{
            border:none !important;
        }
        .fc-button{
            color: #fff !important;
        }
        .fc-h-event, .fc-event-main-frame {
            display: block !important;
            padding-bottom: 10px;
        }
        tr > .prev, .next, .day{
            cursor: pointer;
        }

        .sidebar-calendar-title{
            color: #172340;
            font-size: 24px;
            font-weight: 900;
            letter-spacing: .5px;
            font-family: Avenir-Book,Helvetica,Arial,sans-serif!important;
        }
        .calendarFilterLabel{
            font-family: "Avenir",Helvetica,"Arial",sans-serif;
            font-weight: 800;
            font-size: 18px;
            line-height: 22px;
            color: #4a90e2;
            display: inline-block;
            width: 100%;
        }*/
    </style>
@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    @if(session()->has('success'))
        <div class="row" role="alert">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-check-all me-2"></i>
                    {!! session()->get('success') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="mdi mdi-close me-2"></i>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#calendar" class="btn btn-primary  mb-3">Add New Event <i class="bx bx-calendar"></i> </a>
                </div>
                <div class="card-body" id="fullcalendar"></div>
            </div>
        </div>
    </div>

    <div class="modal right fade" id="calendar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <h6 class="modal-title text-uppercase" id="myModalLabel2">Add To Calendar</h6>
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">New Event</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content p-3 text-muted">

                                <div class="tab-pane active" id="messages1" role="tabpanel">
                                    <form action="{{route('add-calendar-block-event')}}" data-parsley-validate="" method="post" id="blockSessionForm">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Title</label>
                                            <input type="text" data-parsley-required-message="Enter a title for this block session" required name="note" placeholder="Title" class="form-control">
                                            @error('note') <i class="text-danger">{{$message}}</i>@enderror
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="">Start Date & Time</label>
                                            <input type="datetime-local"  data-parsley-required-message="When is this event scheduled to start?" required name="when" placeholder="Start Date & Time" class="form-control when">
                                            @error('when') <i class="text-danger">{{$message}}</i>@enderror
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="">End Date & Time</label>
                                            <input type="datetime-local" id="endDate" data-parsley-required-message="When is this event scheduled to end?" required name="endDate" placeholder="End Date & Time" class="form-control end">
                                            @error('endDate') <i class="text-danger">{{$message}}</i>@enderror
                                            <input type="hidden" name="sessionType" value="3">
                                        </div>
                                        <div class="form-group d-flex justify-content-center mt-3">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-primary  waves-effect waves-light">Add Event <i class="bx bx-right-arrow"></i> </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel2">Add New Client</h4>
                </div>

                <div class="modal-body">
                    <form autocomplete="off" action="{{route('add-client')}}" method="post">
                        @csrf
                        <div class="form-group mt-1">
                            <label for="">First Name <span class="text-danger">*</span></label>
                            <input required type="text" name="firstName" placeholder="First Name" class="form-control">
                            @error('firstName') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Last Name <span class="text-danger">*</span></label>
                            <input required type="text" name="lastName" placeholder="Last Name" class="form-control">
                            @error('lastName') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Mobile Phone Number <span class="text-danger">*</span></label>
                            <input required type="text" name="mobileNo" placeholder="Mobile Phone Number" class="form-control">
                            @error('mobileNo') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Client Group</label>
                            <select required name="clientGroup" id="" class="form-control">
                                @foreach($clientGroups as $cg)
                                    <option value="{{$cg->id}}">{{$cg->group_name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Email Address <span class="text-danger">*</span></label>
                            <input required type="email" name="email" placeholder="Email Address" class="form-control">
                            @error('email') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group d-flex justify-content-center mt-3">
                            <div class="btn-group">
                                <button id="creditChangesBtn" class="btn btn-primary  waves-effect waves-light">Add Client <i class="bx bx-plus"></i> </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="appointmentTypeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel2">New Appointment Type</h4>
                </div>

                <div class="modal-body">
                    <form action="{{route('appointment-types-settings')}}" method="post" id="appointmentType" data-parsley-validate="">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="">Name</label>
                            <input type="text" name="name" required data-parsley-required-message="Give a name to this appointment type..." placeholder="Ex: Nutrition Consultation" class="form-control">
                        </div>
                        <div class="form-check form-checkbox-outline form-check-primary mb-3">
                            <input class="form-check-input" type="checkbox"  checked="" name="groupAppointment">
                            <label class="form-check-label" for="customCheckcolor1">
                                Group Appointment
                            </label>
                        </div>
                        <div class="form-check form-checkbox-outline form-check-primary mb-3">
                            <input class="form-check-input" type="checkbox" name="clientCanBook" id="clientCanBook" checked="">
                            <label class="form-check-label" for="customCheckcolor1">
                                Clients can book this appointment type
                            </label>
                        </div>
                        <div class="ml-4">
                            <div class="form-check form-radio-outline form-radio-primary mb-3">
                                <input class="form-check-input" type="radio" name="allClientBook" checked="">
                                <label class="form-check-label" >
                                    All clients can book
                                </label>
                            </div>
                            <div class="form-check form-radio-outline form-radio-primary mb-3">
                                <input class="form-check-input" type="radio" name="allClientBook">
                                <label class="form-check-label" >
                                    Only visible to specific clients
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">LENGTH</label>
                                    <select name="length" id="" class="form-control">
                                        @for($i = 5; $i<=750; $i+=15)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Contact Types</label>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" name="telehealth" type="checkbox" id="formCheck2" checked="">
                                        <label class="form-check-label">
                                            <i class="bx bx-video mr-2"></i> Telehealth
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" name="inPerson" type="checkbox" id="formCheck2" checked="">
                                        <label class="form-check-label">
                                            <i class="bx bx-building-house mr-2"></i> In Person
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" name="phoneCall" type="checkbox" id="formCheck2" checked="">
                                        <label class="form-check-label">
                                            <i class="bx bx-phone-call mr-2"></i> Phone Call
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-center mt-5">
                            <button class="btn btn-primary">Save <i class="bx bx-right-arrow"></i> </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <h4 class="modal-title" id="myModalLabel2">Event Details</h4>
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row mt-3">
                                <div class="col-12">
                                    <p class="text-muted mb-0">Event Title:</p>
                                    <h6 class="font-size-12" id="eventInfoTitle"></h6>
                                </div>
                                <div class="col-12">
                                    <p class="text-muted mb-0">Starts:</p>
                                    <h6 class="font-size-12" id="eventInfoStart"></h6>
                                </div>
                                <div class="col-12">
                                    <p class="text-muted mb-0">Ends:</p>
                                    <h6 class="font-size-12" id="eventInfoEnds"></h6>
                                </div>
                                 <div class="col-12 d-flex justify-content-center">
                                     <a href="" id="eventInfoLearnMore" class="btn btn-outline-primary btn-sm" target="_blank">Learn more</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script type="text/javascript" src="{{asset('/assets/moment/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/assets/fullcalendar/main.min.js')}}"></script>
    <script src="/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <!-- .fc-event, .fc-event-dot -->
    <script>
        $(document).ready(function(){
            let calendarEl = document.getElementById('fullcalendar');
            let calendarEvents = @json($events);
            let calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar:{
                    left: "prev,next",
                    center: "title",
                    right: "timeGridDay,timeGridWeek,dayGridMonth"
                },
                initialView: 'dayGridMonth',
                events: calendarEvents,
                eventLimit: true,
                editable:false,
                selectable: true,
                selectMirror:true,
                select:function(arg){
                    $('#calendar').modal('show');
                    const startDate = arg.start;
                    const newStartDate = new Date(startDate).toISOString();
                    const endDate = arg.end;
                    const newEndDate = new Date(endDate).toISOString();
                    $('.when').val(`${newStartDate.substring(0, newStartDate.length - 1)}`);
                    $('.end').val(`${newEndDate.substring(0, newEndDate.length - 1)}`);
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    $('#eventInfoTitle').text(info.event.title);
                    $('#eventInfoStart').text(`${new Date(info.event.startStr).toDateString() || null} @ ${new Date(info.event.startStr).toLocaleTimeString()}`);
                    $('#eventInfoEnds').text(`${new Date(info.event.endStr).toDateString() || null } @ ${new Date(info.event.endStr).toLocaleTimeString()}`);
                    $('#eventInfoLearnMore').attr('href', info.event.url);
                    //console.log(`${new Date(info.event.startStr).toLocaleDateString()}`);
                    //alert('View: ' + info.view.type);
                    //console.log(info);
                    $('#infoModal').modal('show');
                }
            });
            calendar.render();
            $('#individualSessionForm').parsley().on('field:validated', function() {
                var ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            })
                .on('form:submit', function() {
                    return true;
            });

            $('#GroupSessionForm').parsley().on('field:validated', function() {
                var ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            })
                .on('form:submit', function() {
                    return true;
            });
            $('#blockSessionForm').parsley().on('field:validated', function() {
                var ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            })
                .on('form:submit', function() {
                    return true;
                });
        })


    </script>
@endsection
