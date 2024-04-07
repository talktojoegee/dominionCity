@extends('layouts.master-layout')
@section('current-page')
    Schedule Detail
@endsection
@section('extra-styles')
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .text-danger{
            color: #ff0000 !important;
        }
        .checked {
            color: orange;
        }
    </style>
@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')

    <div class="container-fluid">
        <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12 col-lg-12 d-flex justify-content-end mb-4 mr-4">
                                        <button class="btn btn-danger btn-sm" data-bs-target="#rateSchedule" data-bs-toggle="modal" type="button">Rate <i class="bx bxs-pencil"></i> </button>
                                    </div>
                                    <div class="modal-header">
                                        <h6 class="text-uppercase modal-title"> Details</h6>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-12 col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table table-nowrap mb-0">
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">Scheduled By:</th>
                                                        <td> {{$record->getScheduledBy->title ?? '' }} {{$record->getScheduledBy->first_name ?? '' }} {{$record->getScheduledBy->last_name ?? '' }} </td>
                                                        @if($record->status != 0)
                                                            <th scope="row">Actioned By:</th>
                                                            <td> {{$record->getScheduledBy->title ?? '' }} {{$record->getScheduledBy->first_name ?? '' }} {{$record->getScheduledBy->last_name ?? '' }} </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Date :</th>
                                                        <td>{{ date('d M, Y', strtotime($record->entry_date)) }} </td>
                                                        @if($record->status != 0)
                                                            <th scope="row">Action Date:</th>
                                                            <td> {{ date('d M, Y', strtotime($record->action_date)) }}  </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Period:</th>
                                                        <td> <span style="background: #f46a6a; padding:4px; color:#fff;">{{ date('F', mktime(0, 0, 0, $record->period_month, 10)) }}, {{ $record->period_year ?? '' }}</span> </td>
                                                        @if($record->status != 0)
                                                            <th scope="row">Rating:</th>
                                                            <td>
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <span class="fa fa-star {{ $i <= $record->score ? 'checked' : '' }}"></span>
                                                                @endfor
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Status: </th>
                                                        <td>
                                                            @switch($record->status)
                                                                @case(0)
                                                                <span class="text-warning">New</span>
                                                                @break
                                                                @case(1)
                                                                <span class="text-success">Open</span>
                                                                @break
                                                                @case(2)
                                                                <span class="text-danger">Closed</span>
                                                                @break
                                                            @endswitch
                                                        </td>
                                                        @if($record->status != 0)
                                                            <th scope="row">Comment:</th>
                                                            <td>
                                                                {{ $record->comment ?? '' }}
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Title:</th>
                                                        <td>{{ $record->title ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Objectives</th>
                                                        <td>{{$record->objective ?? '' }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 mt-3">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Mobile No.</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Gender</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($record->getLeadScheduleDetails as $key => $rec)
                                                    <tr>
                                                        <th scope="row">{{$key + 1}}</th>
                                                        <td><a target="_blank" href="{{ route('lead-profile', $rec->getLead->slug) }}">{{$rec->getLead->first_name ?? '' }} {{$rec->getLead->last_name ?? '' }} </a> </td>
                                                        <td>{{$rec->getLead->phone ?? '' }}</td>
                                                        <td>{{$rec->getLead->email ?? '' }}</td>
                                                        <td>{{$rec->getLead->gender == 1 ? 'Male' : 'Female' }}</td>
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
    </div>
    <div class="modal fade" id="rateSchedule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <h6 class="modal-title text-uppercase">Rate Schedule</h6>
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" action="{{ route('rate-followup-schedule') }}" method="post">
                        @csrf
                        <div class="mt-2">
                            <div class="form-group">
                                <label for="">Status</label>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-check form-radio-outline form-radio-primary mb-3">
                                        <input class="form-check-input" type="radio" name="status" value="0" id="new" {{$record->status == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="new">
                                            New Schedule
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-check form-radio-outline form-radio-success mb-3">
                                        <input class="form-check-input" type="radio" name="status" value="1" id="open" {{$record->status == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="open">
                                            Open
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-check form-radio-outline form-radio-danger mb-3">
                                        <input class="form-check-input" type="radio" name="status" value="2" id="close" {{$record->status == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="close">
                                            Close
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label for="">Score</label>
                            <select name="score" id="" class="form-control">
                                @for($i = 1; $i<=5; $i++)
                                    <option value="{{$i}}">{{$i }} star{{$i > 1 ? 's' : ''  }}</option>
                                @endfor
                            </select>
                            <input type="hidden" value="{{ $record->id }}" name="schedule">
                            @error('score') <i class="text-danger">{{$message}}</i> @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="">Comment</label>
                            <textarea name="comment" style="resize: none;" placeholder="Leave comment here..." class="form-control">{{ old('comment') }}</textarea>
                            @error('comment') <i class="text-danger">{{$message}}</i> @enderror
                        </div>
                        <div class="form-group d-flex justify-content-center mt-3">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary  waves-effect waves-light">Submit <i class="bx bx-check-circle"></i> </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')

@endsection
