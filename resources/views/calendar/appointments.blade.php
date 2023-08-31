@extends('layouts.master-layout')
@section('current-page')
    All Appointments
@endsection
@section('extra-styles')
    <link rel="stylesheet" href="/css/nprogress.css">
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/parsley.css" rel="stylesheet" type="text/css" />
<style>
    .fs-22{
        font-size: 22px;
    }
</style>
@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-1">
                            <div class="col">
                                <p class="mb-2">Appointments</p>
                                <h3 class="mb-0 number-font">{{number_format($appointments->count())}}</h3>
                            </div>
                            <div class="col-auto mb-0">
                                <div class="dash-icon text-orange"> <i class="bx bxs-timer text-success fs-22" ></i></div>
                            </div>
                        </div>
                        <span class="fs-12 text-success"> <strong>Overall</strong> </span>
                        <span class="text-muted fs-12 ms-0 mt-1">Appointments </span>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-1">
                            <div class="col"> <p class="mb-2">Appointments</p><h3 class="mb-0 number-font">{{ number_format($yesterdays->count()) }}</h3> </div>
                            <div class="col-auto mb-0">
                                <div class="dash-icon text-secondary1"> <i class="bx bxs-timer text-warning fs-22"></i> </div>
                            </div>
                        </div>
                        <span class="fs-12 text-warning"> <strong>Yesterday's</strong>  </span>
                        <span class="text-muted fs-12 ms-0 mt-1">Appointments </span>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-1">
                            <div class="col"> <p class="mb-2">Appointments</p>
                                <h3 class="mb-0 number-font">{{number_format($todays->count())}}</h3>
                            </div>
                            <div class="col-auto mb-0">
                                <div class="dash-icon text-secondary"> <i class="bx bxs-timer text-primary fs-22"></i>
                                </div>
                            </div>
                        </div>
                        <span class="fs-12 text-primary"> <strong>Today's</strong>  </span>
                        <span class="text-muted fs-12 ms-0 mt-1">Appointments </span>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-1">
                            <div class="col">
                                <p class="mb-2">Appointments</p>
                                <h3 class="mb-0 number-font">{{number_format($thisWeek->count())}}</h3>
                            </div>
                            <div class="col-auto mb-0">
                                <div class="dash-icon text-warning"> <i class="bx bxs-timer text-info fs-22"></i> </div>
                            </div>
                        </div>
                        <span class="fs-12 text-info"> <strong>This Week's</strong>  </span>
                        <span class="text-muted fs-12 ms-0 mt-1">Appointments </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#client" class="btn btn-primary  mb-3">Add New Appointment <i class="bx bxs-timer"></i> </a>
                    </div>
                    <div class="card-body">

                        <h4 class="card-title">All Appointments</h4>
                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-check-all me-2"></i>
                                {!! session()->get('success') !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                            <div class="col-md-12 col-lx-12">
                                <div class="table-responsive mt-3">
                                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th class="">#</th>
                                            <th class="wd-15p">Name</th>
                                            <th class="wd-15p">Date & Time</th>
                                            <th class="wd-15p">Type</th>
                                            <th class="wd-15p">Contact</th>
                                            <th class="wd-15p">Status</th>
                                            <th class="wd-15p">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $index = 1; @endphp
                                        @foreach($appointments as $appoint)
                                            <tr>
                                                <td>{{$index++}}</td>
                                                <td>
                                                    @if($appoint->session_type != 3)
                                                    @foreach($appoint->getInvitees->take(1) as $invite)
                                                        {{$invite->getClient->first_name ?? ''  }}  {{$invite->getClient->last_name ?? ''  }}
                                                    @endforeach
                                                    @if($appoint->getInvitees->count() > 1)
                                                       <small class="badge rounded-pill bg-info">+{{$appoint->getInvitees->count() - 1}} others</small>
                                                    @endif
                                                    @else
                                                        <span class="text-warning">Block Session</span>
                                                    @endif

                                                </td>
                                                <td>
                                                    @if($appoint->session_type != 3)
                                                    {{date('d M, Y', strtotime($appoint->event_date))}} <u class="text-info">{{date('h:ia', strtotime($appoint->event_date))}}</u>
                                                    @else
                                                        <strong>From: </strong>{{date('d M, Y', strtotime($appoint->event_date))}} <u class="text-info">{{date('h:ia', strtotime($appoint->event_date))}}</u>
                                                        <br>
                                                        <strong>To: </strong>{{date('d M, Y', strtotime($appoint->end_date))}} <u class="text-info">{{date('h:ia', strtotime($appoint->end_date))}}</u>
                                                    @endif

                                                </td>
                                                <td>
                                                    @if($appoint->session_type != 3)
                                                        {{$appoint->getAppointmentType->name ?? '' }}
                                                    @else
                                                        <span class="text-warning">Block Session</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($appoint->session_type != 3)
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
                                                    @else
                                                        <span class="text-warning">Block Session</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($appoint->session_type != 3)
                                                        @switch($appoint->status)
                                                            @case(1)
                                                            <label for="" class="badge badge-soft-primary">Booked</label>
                                                            @break
                                                            @case(2)
                                                            <label for="" class="badge badge-soft-success">Confirmed</label>
                                                            @break
                                                            @case(3)
                                                            <label for="" class="badge-soft-danger badge">Cancelled</label>
                                                            @break
                                                            @case(4)
                                                            <label for="" class="badge badge-soft-warning">Repeat</label>
                                                            @break
                                                        @endswitch
                                                    @else
                                                        <span class="text-warning">Block Session</span>
                                                    @endif
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
        </div>
    </div>

    <div class="modal right fade" id="client" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <h6 class="modal-title text-uppercase" id="myModalLabel2">Add New Appointment</h6>
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('add-calendar-event')}}" data-parsley-validate="" method="post" id="individualSessionForm">
                        @csrf
                        <div class="form-group">
                            <label for="">Invitee</label>
                            <select name="invitee" id="" class="form-control" data-parsley-required-message="Who are you inviting?" required>
                                @foreach($clients as $client)
                                    <option value="{{$client->id}}">{{$client->first_name ?? '' }} {{$client->last_name ?? '' }}</option>
                                @endforeach
                            </select>
                            @error('invitee') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Appointment Type</label>
                            <select name="appointmentType" id="" class="form-control" data-parsley-required-message="Choose an appointment type" required>
                                @foreach($appointmentTypes as $type)
                                    <option value="{{$type->id}}">{{$type->name ?? '' }} - {{$type->length ?? '' }} minutes </option>
                                @endforeach
                            </select>
                            @error('appointmentType') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Contact Type</label>
                            <select name="contactType" id="" class="form-control" data-parsley-required-message="Choose contact type" required>
                                <option value="1">Video Call</option>
                                <option value="2">In Person</option>
                                <option value="3">Phone Call</option>
                            </select>
                            <input type="hidden" name="sessionType" value="1">
                            @error('contactType') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">When</label>
                            <input type="datetime-local" name="when" class="form-control" data-parsley-required-message="When is this event taking place?" required>
                            @error('when') <i class="text-danger">{{$message}}</i> @enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Note</label>
                            <textarea name="note" id="note" data-parsley-required-message="Leave a note that best describes it." required placeholder="Leave a note here..." rows="5" style="resize: none" class="form-control"></textarea>
                            @error('note') <i class="text-danger">{{$message}}</i> @enderror
                        </div>
                        <div class="form-group d-flex justify-content-center mt-3">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary  waves-effect waves-light">Add Individual Session <i class="bx bx-right-arrow"></i> </button>
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
    <script src="/assets/js/pages/datatables.init.js"></script>
    <script src="/js/parsley.js"></script>
    <script>
        $(document).ready(function(){
            $('#individualSessionForm').parsley().on('field:validated', function() {
                var ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            })
                .on('form:submit', function() {
                    return true;
                });
        });
    </script>
@endsection
