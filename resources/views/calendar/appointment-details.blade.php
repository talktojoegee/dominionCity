@extends('layouts.master-layout')
@section('current-page')
    Event Details
@endsection
@section('extra-styles')
    <link rel="stylesheet" href="/css/nprogress.css">
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/parsley.css" rel="stylesheet" type="text/css" />
@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{route('show-appointments')}}" class="btn btn-primary  mb-3">All Events <i class="bx bxs-timer"></i> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        @if($appointment->session_type == 1)
            <div class="col-xl-8">
                <div class="card overflow-hidden">
                    <div class="bg-primary bg-soft">
                        <div class="row ">
                            <div class="col-4">
                                <div class="text-primary p-3 mb-3">
                                    <h5 class="text-primary"> {{$appointment->session_type == 1 ? "1:1 Session" : "Block Session"}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <img src="{{url('storage/'.$appointment->getClient->avatar)}}" alt="" class="img-thumbnail rounded-circle">
                                </div>
                                <h5 class="font-size-15 text-truncate">{{$appointment->getClient->first_name ?? '' }} {{$appointment->getClient->last_name ?? '' }}</h5>
                                <p class="text-muted mb-0 text-truncate"> {{$appointment->getClient->getClientGroup->group_name ?? '' }}</p>
                                <div class="row mt-3">
                                    <div class="col-6" style="border-right: 2px solid #656B7A;">
                                        <p class="text-muted mb-0 text-center">Upcoming</p>
                                        <h5 class="font-size-15 text-center">{{number_format($upcomingAppointments->count())}}</h5>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted mb-0 text-center">Past</p>
                                        <h5 class="font-size-15 text-center">{{number_format($pastAppointments->count())}}</h5>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center mt-3">
                                        <button data-bs-toggle="modal" data-bs-target="#sendMessageModal" class="btn btn-light">Send Message <i class="bx bxs-send"></i> </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive mt-2">
                                            <table class="table table-bordered mb-0">
                                                <tbody>
                                                <tr>
                                                    <td><strong>Gender</strong> <br>
                                                        {{$appointment->getClient->gender == 1 ? 'Male' : 'Female'}}
                                                    </td>
                                                    <td> <strong>Birthday</strong> <br>
                                                        {{!is_null($appointment->getClient->birth_date) ? date('d M, Y', strtotime($appointment->getClient->birth_date)) : '-' }}
                                                    </td>
                                                    <td><strong>Cellphone</strong> <br>
                                                        {{$appointment->getClient->mobile_no ?? '' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Address</strong> <br>
                                                        {{$appointment->getClient->address ?? '-' }}
                                                    </td>
                                                    <td> <strong>City</strong> <br>
                                                        12-12-2022
                                                    </td>
                                                    <td><strong>Current Weight</strong> <br>
                                                        {{$appointment->getClient->current_weight ?? '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Account Status</strong> <br>
                                                        {{$appointment->getClient->status == 1 ? 'Active' : 'Inactive' }}
                                                    </td>
                                                    <td> <strong>Member Since</strong> <br>
                                                        {{date('d M, Y', strtotime($appointment->getClient->created_at))  }}
                                                    </td>
                                                    <td><strong>Email</strong> <br>
                                                        {{$appointment->getClient->email ?? '' }}
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header bg-primary text-white  ">Appointment Details</div>
                            <div class="card-body">
                                <div class="col-12">
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <p class="text-muted mb-0">Date & Time</p>
                                            <h6 class="font-size-12">{{date('d M, Y', strtotime($appointment->event_date))}} <u class="text-info">{{date('h:i a', strtotime($appointment->event_date))}}</u></h6>
                                        </div>
                                        <div class="col-4">
                                            <p class="text-muted mb-0">Location</p>
                                            <h6 class="font-size-12">{{$appointment->getLocation->location_name ?? 'No Location Chosen' }}</h6>
                                        </div>
                                        <div class="col-4">
                                            <p class="text-muted mb-0">Room</p>
                                            <h6 class="font-size-12">{{$appointment->getRoom->name ?? 'No Room Chosen' }}</h6>
                                        </div>
                                        <div class="col-4">
                                            <p class="text-muted mb-0">Appointment Type</p>
                                            <h6 class="font-size-12">{{$appointment->getAppointmentType->name ?? "-"}}</h6>
                                        </div>
                                        <div class="col-4">
                                            <p class="text-muted mb-0">Attendance</p>
                                            <h6 class="font-size-12">{{$appointment->max_attendees ?? 0}}</h6>
                                        </div>
                                        <div class="col-4">
                                            <p class="text-muted mb-0">Status <span style="cursor: pointer;" data-bs-target="#updateAppointmentStatus" data-bs-toggle="modal"> <i class="bx bxs-pencil text-info" title="Update Status"></i> </span> </p>
                                            <h6 class="font-size-12">
                                                @switch($appointment->status)
                                                    @case(1)
                                                    <label for="" class="badge badge-soft-primary">Booked</label>
                                                    @break
                                                    @case(2)
                                                    <label for="" class="badge badge-soft-success">Confirmed</label>
                                                    @break
                                                    @case(3)
                                                    <label for="" class="badge-soft-danger badge">Unconfirmed</label>
                                                    @break
                                                    @case(4)
                                                    <label for="" class="badge badge-soft-warning">Repeat</label>
                                                    @break
                                                @endswitch
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($appointment->session_type == 3)
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header bg-dark text-white  ">Appointment Details</div>
                    <div class="card-body">
                        <div class="col-12">
                            <div class="row mt-3">
                                <div class="col-4">
                                    <p class="text-muted mb-0">From:</p>
                                    <h6 class="font-size-12">{{date('d M, Y', strtotime($appointment->event_date))}} <u class="text-info">{{date('h:i a', strtotime($appointment->event_date))}}</u></h6>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted mb-0">To:</p>
                                    <h6 class="font-size-12">{{date('d M, Y', strtotime($appointment->end_date))}} <u class="text-info">{{date('h:i a', strtotime($appointment->end_date))}}</u></h6>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted mb-0">Location</p>
                                    <h6 class="font-size-12">{{$appointment->getLocation->location_name ?? 'No Location Chosen' }}</h6>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted mb-0">Room</p>
                                    <h6 class="font-size-12">{{$appointment->getRoom->name ?? 'No Room Chosen' }}</h6>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted mb-0">Appointment Type</p>
                                    <h6 class="font-size-12">{{$appointment->getAppointmentType->name ?? "-"}}</h6>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted mb-0">Attendance</p>
                                    <h6 class="font-size-12">{{$appointment->max_attendees ?? 0}}</h6>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted mb-0">Status <span style="cursor: pointer;" data-bs-target="#updateAppointmentStatus" data-bs-toggle="modal"> <i class="bx bxs-pencil text-info" title="Update Status"></i> </span> </p>
                                    <h6 class="font-size-12">
                                        @switch($appointment->status)
                                            @case(1)
                                            <label for="" class="badge badge-soft-primary">Booked</label>
                                            @break
                                            @case(2)
                                            <label for="" class="badge badge-soft-success">Confirmed</label>
                                            @break
                                            @case(3)
                                            <label for="" class="badge-soft-danger badge">Unconfirmed</label>
                                            @break
                                            @case(4)
                                            <label for="" class="badge badge-soft-warning">Repeat</label>
                                            @break
                                        @endswitch
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header mb-2 mt-2 bg-dark text-white">
                    Block Session
                </div>
                <ul class="verti-timeline list-unstyled mt-0" style="overflow-y: scroll; height: 300px;">

                    @foreach($appointment->getInvitees as $key => $invitee)
                        <li class="event-list" style="{{$key != 0 ? 'margin-top: -50px;' : ''}}">
                            <div class="event-timeline-dot">
                                <i class="bx bx-right-arrow-circle font-size-18"></i>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <img class="d-flex-object rounded-circle avatar-xs" alt="" src="{{url('storage/'.$invitee->getClient->avatar)}}">
                                            <i class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="row">
                                                <div class="col-5">
                                                    {{$invitee->getClient->first_name ?? '' }}  {{$invitee->getClient->last_name ?? '' }}
                                                </div>
                                                <div class="col-2" style="border-left: 2px solid #dddddd;">
                                                    @switch($appointment->status)
                                                        @case(1)
                                                        <label for="" class="badge badge-soft-primary">Booked</label>
                                                        @break
                                                        @case(2)
                                                        <label for="" class="badge badge-soft-success">Confirmed</label>
                                                        @break
                                                        @case(3)
                                                        <label for="" class="badge-soft-danger badge">Unconfirmed</label>
                                                        @break
                                                        @case(4)
                                                        <label for="" class="badge badge-soft-warning">Repeat</label>
                                                        @break
                                                    @endswitch
                                                </div>
                                                <div class="col-2" style="border-left: 2px solid #dddddd;">
                                                    @switch($appointment->contact_type)
                                                        @case(1)
                                                        Video Call
                                                        @break
                                                        @case(2)
                                                        In Person
                                                        @break
                                                        @case(3)
                                                        Phone Call
                                                        @break
                                                    @endswitch
                                                </div>
                                                <div class="col-3" style="border-left: 2px solid #dddddd;">
                                                    <a class="dropdown-item text-wrap" href="{{route('view-client-profile', $invitee->getClient->slug)}}">View Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header bg-dark text-white  ">Appointment Details</div>
                    <div class="card-body">
                        <div class="col-12">
                            <div class="row mt-3">
                                <div class="col-4">
                                    <p class="text-muted mb-0">Date & Time</p>
                                    <h6 class="font-size-12">{{date('d M, Y', strtotime($appointment->event_date))}} <u class="text-info">{{date('h:i a', strtotime($appointment->event_date))}}</u></h6>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted mb-0">Location</p>
                                    <h6 class="font-size-12">{{$appointment->getLocation->location_name ?? 'No Location Chosen' }}</h6>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted mb-0">Room</p>
                                    <h6 class="font-size-12">{{$appointment->getRoom->name ?? 'No Room Chosen' }}</h6>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted mb-0">Appointment Type</p>
                                    <h6 class="font-size-12">{{$appointment->getAppointmentType->name ?? "-"}}</h6>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted mb-0">Attendance</p>
                                    <h6 class="font-size-12">{{$appointment->max_attendees ?? 0}}</h6>
                                </div>
                                <div class="col-4">
                                    <p class="text-muted mb-0">Status <span style="cursor: pointer;" data-bs-target="#updateAppointmentStatus" data-bs-toggle="modal"> <i class="bx bxs-pencil text-info" title="Update Status"></i> </span> </p>
                                    <h6 class="font-size-12">
                                        @switch($appointment->status)
                                            @case(1)
                                            <label for="" class="badge badge-soft-primary">Booked</label>
                                            @break
                                            @case(2)
                                            <label for="" class="badge badge-soft-success">Confirmed</label>
                                            @break
                                            @case(3)
                                            <label for="" class="badge-soft-danger badge">Unconfirmed</label>
                                            @break
                                            @case(4)
                                            <label for="" class="badge badge-soft-warning">Repeat</label>
                                            @break
                                        @endswitch
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header mb-2 mt-2 bg-dark text-white">
                    Group Session
                </div>
                <ul class="verti-timeline list-unstyled mt-0" style="overflow-y: scroll; height: 300px;">

                    @foreach($appointment->getInvitees as $key => $invitee)
                     <li class="event-list" style="{{$key != 0 ? 'margin-top: -50px;' : ''}}">
                        <div class="event-timeline-dot">
                            <i class="bx bx-right-arrow-circle font-size-18"></i>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <img class="d-flex-object rounded-circle avatar-xs" alt="" src="{{url('storage/'.$invitee->getClient->avatar)}}">
                                        <i class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="row">
                                            <div class="col-5">
                                                {{$invitee->getClient->first_name ?? '' }}  {{$invitee->getClient->last_name ?? '' }}
                                            </div>
                                            <div class="col-2" style="border-left: 2px solid #dddddd;">
                                                @switch($appointment->status)
                                                    @case(1)
                                                    <label for="" class="badge badge-soft-primary">Booked</label>
                                                    @break
                                                    @case(2)
                                                    <label for="" class="badge badge-soft-success">Confirmed</label>
                                                    @break
                                                    @case(3)
                                                    <label for="" class="badge-soft-danger badge">Unconfirmed</label>
                                                    @break
                                                    @case(4)
                                                    <label for="" class="badge badge-soft-warning">Repeat</label>
                                                    @break
                                                @endswitch
                                            </div>
                                            <div class="col-2" style="border-left: 2px solid #dddddd;">
                                                @switch($appointment->contact_type)
                                                    @case(1)
                                                    Video Call
                                                    @break
                                                    @case(2)
                                                    In Person
                                                    @break
                                                    @case(3)
                                                    Phone Call
                                                    @break
                                                @endswitch
                                            </div>
                                            <div class="col-3" style="border-left: 2px solid #dddddd;">
                                                <a class="dropdown-item text-wrap" href="{{route('view-client-profile', $invitee->getClient->slug)}}">View Profile</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Notes</h4>
                    <div class="row mb-3">
                        <div class="col-md-12 bg-light p-4">
                             <i class="bx bxs-pin text-info"></i> {{$appointment->note ?? '' }}
                        </div>
                    </div>
                    <div style="overflow-y: scroll; height: 300px;">
                        @foreach($appointment->getComments as $comment)
                            <div class="d-flex mb-4">
                                <div class="flex-shrink-0 me-3">
                                    <img class="d-flex-object rounded-circle avatar-xs" alt="" src="{{url('storage/'.$comment->getCommentedBy->image ?? 'avatar.png')}}">
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="font-size-13 mb-1">{{$comment->getCommentedBy->first_name ?? '' }} {{$comment->getCommentedBy->last_name ?? '' }} <small><u class="text-info">{{date('d M, Y h:ia', strtotime($comment->created_at))}}</u></small></h5>
                                    <p class="text-muted mb-1">
                                        {{$comment->note ?? '' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-4 pt-2">
                        <a href="javascript: void(0);" data-bs-target="#leaveNoteModal" data-bs-toggle="modal" class="btn btn-primary btn-sm">Leave a note <i class="mdi mdi-pencil"></i> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <p>Showing other appointments where one or more of the invitees in the select appointment was involved.</p>
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block"> Upcoming Events</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Past Events</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="home1" role="tabpanel">
                            <ul class="verti-timeline list-unstyled mt-3">
                                @if($upcomingAppointments->count() > 0 )
                                    @foreach($upcomingAppointments as $up)
                                        <li class="event-list">
                                            <div class="event-timeline-dot">
                                                <i class="bx bx-right-arrow-circle font-size-18"></i>
                                            </div>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <h5 class="font-size-14">{{date('d M, Y', strtotime($up->event_date))}} | {{date('h:i a', strtotime($up->event_date))}} <i class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i></h5>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    {{strlen($up->note) > 20 ? substr($up->note, 0, 17).'...' : $up->note }}
                                                                </div>
                                                                <div class="col-2" style="border-left: 2px solid #dddddd;">
                                                                    @switch($up->status)
                                                                        @case(1)
                                                                        <label for="" class="badge badge-soft-primary">Booked</label>
                                                                        @break
                                                                        @case(2)
                                                                        <label for="" class="badge badge-soft-success">Confirmed</label>
                                                                        @break
                                                                        @case(3)
                                                                        <label for="" class="badge-soft-danger badge">Unconfirmed</label>
                                                                        @break
                                                                        @case(4)
                                                                        <label for="" class="badge badge-soft-warning">Repeat</label>
                                                                        @break
                                                                    @endswitch
                                                                </div>
                                                                <div class="col-2" style="border-left: 2px solid #dddddd;">
                                                                    @switch($up->contact_type)
                                                                        @case(1)
                                                                        Video Call
                                                                        @break
                                                                        @case(2)
                                                                        In Person
                                                                        @break
                                                                        @case(3)
                                                                        Phone Call
                                                                        @break
                                                                    @endswitch
                                                                </div>
                                                                <div class="col-2" style="border-left: 2px solid #dddddd;">
                                                                    <a class="dropdown-item" href="{{route('show-appointment-details', $up->slug)}}"> <i class="bx bxs-book-open"></i> View</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="event-list text-center">
                                        There are no upcoming events with any of the invitees
                                    </li>
                                @endif

                            </ul>
                        </div>
                        <div class="tab-pane" id="profile1" role="tabpanel">
                            <div class="table-responsive mt-3">
                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                    <thead>
                                    <tr>
                                        <th class="">#</th>
                                        <th class="wd-15p">Client</th>
                                        <th class="wd-15p">Date & Time</th>
                                        <th class="wd-15p">Type</th>
                                        <th class="wd-15p">Contact</th>
                                        <th class="wd-15p">Status</th>
                                        <th class="wd-15p">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $index = 1; @endphp
                                    @foreach($pastAppointments as $appoint)
                                        <tr>
                                            <td>{{$index++}}</td>
                                            <td>
                                                @switch($appoint->session_type)
                                                    @case(1)
                                                    {{$appoint->getClient->first_name ?? '' }} {{$appoint->getClient->last_name ?? '' }}
                                                    @break
                                                    @case(2)
                                                    @foreach($appoint->getInvitees->take(1) as $invite)
                                                        {{$invite->getClient->first_name ?? ''  }}  {{$invite->getClient->last_name ?? ''  }}
                                                    @endforeach
                                                    <small class="badge rounded-pill bg-info">+{{$appoint->getInvitees->count() - 1}} others</small>
                                                    @break
                                                @endswitch
                                            </td>
                                            <td>{{date('d M, Y', strtotime($appoint->event_date))}} <u class="text-info">{{date('h:ia', strtotime($appoint->event_date))}}</u>  </td>
                                            <td>{{$appoint->getAppointmentType->name ?? '' }}</td>
                                            <td>
                                                @switch($appoint->contact_type)
                                                    @case(1)
                                                    Video Call
                                                    @break
                                                    @case(2)
                                                    In Person
                                                    @break
                                                    @case(3)
                                                    Phone Call
                                                    @break
                                                @endswitch
                                            </td>
                                            <td>
                                                @switch($appoint->status)
                                                    @case(1)
                                                    <label for="" class="badge badge-soft-primary">Booked</label>
                                                    @break
                                                    @case(2)
                                                    <label for="" class="badge badge-soft-success">Confirmed</label>
                                                    @break
                                                    @case(3)
                                                    <label for="" class="badge-soft-danger badge">Unconfirmed</label>
                                                    @break
                                                    @case(4)
                                                    <label for="" class="badge badge-soft-warning">Repeat</label>
                                                    @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <i class="bx bx-dots-vertical dropdown-toggle text-warning" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{route('show-appointment-details', $appoint->slug)}}"> <i class="bx bxs-book-open"></i> View</a>
                                                    </div>
                                                </div>
                                            </td>
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
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white mb-4">Files/Documents</div>
                <div class="card-body">
                    <div class="table-responsive" style="overflow-y: scroll; height: 300px;">
                        <table class="table table-nowrap align-middle table-hover mb-0">
                            <tbody>
                            @if($appointment->getDocuments->count() > 0)
                                @foreach($appointment->getDocuments as $file)
                                    <tr>
                                        <td style="width: 45px;">
                                            <div class="avatar-sm">
                                            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                                <i class="bx bxs-file-doc"></i>
                                            </span>
                                            </div>
                                        </td>
                                        <td>
                                            <h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">{{$file->name ?? '' }}</a></h5>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <a href="{{route('download-attachment',['slug'=>$file->filename])}}" class="text-dark"><i class="bx bx-download h3 m-0"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">No files/documents shared.</td>
                                </tr>
                            @endif

                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-4"><a href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#shareAttachments" class="btn btn-primary waves-effect waves-light btn-sm">Share Attachment(s) <i class="mdi mdi-upload ms-1"></i></a></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal right fade" id="sendMessageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel2">Send Message</h4>
                </div>
                <div class="modal-body">
                    <form action="{{route('add-calendar-event')}}" data-parsley-validate="" method="post" id="individualSessionForm">
                        @csrf
                        <div class="form-group mt-1">
                            <label for="">Subject <span class="text-danger">*</span> </label>
                            <input type="text" placeholder="Subject" name="subject" class="form-control" data-parsley-required-message="What's the subject of your message?" required>
                            @error('subject') <i class="text-danger">{{$message}}</i> @enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Message <span class="text-danger">*</span> </label>
                            <textarea name="message" id="message" data-parsley-required-message="Type your message in the field provided." required placeholder="Leave your message here..." rows="5" style="resize: none" class="form-control"></textarea>
                            @error('message') <i class="text-danger">{{$message}}</i> @enderror
                        </div>
                        <div class="form-group d-flex justify-content-center mt-3">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary  waves-effect waves-light">Send Message <i class="bx bx-right-arrow"></i> </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal right fade" id="leaveNoteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel2">Leave A Note</h4>
                </div>
                <div class="modal-body">
                    <form action="{{route('leave-a-note')}}" data-parsley-validate="" method="post" id="leaveNoteForm">
                        @csrf
                        <div class="form-group mt-1">
                            <label for="">Leave a note <span class="text-danger">*</span> </label>
                            <textarea name="note" id="note" data-parsley-required-message="Leave a note." required placeholder="Leave your note here..." rows="5" style="resize: none" class="form-control"></textarea>
                            @error('note') <i class="text-danger">{{$message}}</i> @enderror
                            <input type="hidden" value="{{$appointment->id}}" name="appointmentId">
                        </div>
                        <div class="form-group d-flex justify-content-center mt-3">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary  waves-effect waves-light">Leave a note <i class="bx bx-right-arrow"></i> </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="modal right fade" id="shareAttachments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel2">Share Attachments</h4>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" action="{{route('upload-files')}}" data-parsley-validate="" method="post" id="shareAttachmentsForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="">File Name <sup class="text-danger">*</sup> </label>
                            <input type="text" name="fileName" data-parsley-required-message="Enter a file name" required placeholder="File Name" class="form-control">
                            <input type="hidden" name="calendarId" value="{{$appointment->id}}">
                            @error('fileName')
                            <i class="text-danger mt-2">{{$message}}</i>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Attachment <sup class="text-danger">*</sup> </label> <br>
                            <input type="file" name="attachments[]" data-parsley-required-message="Choose file(s) to share" required  class="form-control-file" multiple>
                            @error('attachments')
                            <i class="text-danger mt-2">{{$message}}</i>
                            @enderror
                            <input type="hidden" name="folder" value="0">
                        </div>
                        <hr>
                        <div class="form-group d-flex justify-content-center">
                            <div class="btn-group">
                                <a href="{{url()->previous()}}" class="btn btn-warning btn-mini"><i class="bx bx-left-arrow mr-2"></i> Go Back</a>
                                <button type="submit" class="btn btn-custom"><i class="bx bx-cloud-upload mr-2"></i> Upload File(s)</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="updateAppointmentStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <h4 class="modal-title" id="myModalLabel2">Change Status</h4>
                </div>
                <div class="modal-body">
                    <form action="{{route('change-status')}}" data-parsley-validate="" method="post" id="shareAttachmentsForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mt-1">
                            <label for="">Status <span class="text-danger">*</span> </label>
                            <select name="status"  class="form-control">
                                <option disabled selected>--Select status--</option>
                                <option value="1">Booked</option>
                                <option value="2">Confirmed</option>
                                <option value="3">Unconfirmed</option>
                                <option value="4">Repeat</option>
                            </select>
                            <input type="hidden" name="calendarId" value="{{$appointment->id}}">
                            @error('status') <i class="text-danger">{{$message}}</i> @enderror
                        </div>
                        <div class="form-group d-flex justify-content-center mt-3">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary  waves-effect waves-light">Save changes <i class="bx bx-right-arrow"></i> </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script src="/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script src="/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <!-- Datatable init js -->
    <script src="/assets/js/pages/datatables.init.js"></script>
    <script src="/js/parsley.js"></script>
    <script>
        $(document).ready(function(){
            $('#leaveNoteForm').parsley().on('field:validated', function() {
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
