
@extends('layouts.master-layout')
@section('current-page')
    Manage Bulk Leads Details
@endsection
@section('extra-styles')

@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">

                    <div class="card-body">
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
                        @include('followup.partial._top-navigation')
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route("leads") }}"  class="btn btn-primary"> Manage Leads <i class="bx bxs-briefcase-alt-2"></i> </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-xl-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Bulk Import Information</h4>
                                <p class="text-muted mb-4">You'll find below information related to the person that carried out this action among other things.</p>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="table-responsive">
                                            <table class="table table-nowrap mb-0">
                                                <tbody>
                                                <tr>
                                                    <th scope="row">Full Name:</th>
                                                    <td>{{ $record->getImportedBy->title ?? ''  }}  {{ $record->getImportedBy->first_name ?? ''  }} {{ $record->getImportedBy->last_name ?? ''  }} {{ $record->getImportedBy->other_names ?? ''  }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Email :</th>
                                                    <td>{{ $record->getImportedBy->email ?? ''  }} </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Mobile No.  :</th>
                                                    <td> {{ $record->getImportedBy->cellphone_no ?? ''  }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Date Imported:</th>
                                                    <td>{{ date('d F, Y', strtotime($record->created_at)) }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Batch Code :</th>
                                                    <td>{{ $record->batch_code ?? ''  }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="table-responsive">
                                            <table class="table table-nowrap mb-0">
                                                <tbody>
                                                <tr>
                                                    <th scope="row">Status :</th>
                                                    <td>
                                                        @switch($record->status)
                                                            @case(0)
                                                            <span class="text-warning">Pending</span>
                                                            @break
                                                            @case(1)
                                                            <span class="text-success">Approved</span>
                                                            @break
                                                            @case(2)
                                                            <span class="text-danger">Discarded</span>
                                                            @break
                                                        @endswitch
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-nowrap mb-0">
                                                <tbody>
                                                <tr>
                                                    <th scope="row">Narration :</th>
                                                    <td>{{ $record->narration ?? ''  }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 mb-2 mt-2 d-flex justify-content-end">
                        @if($record->status == 0)
                            <div class="btn-group">
                                <a href="{{ route("post-lead-record", $record->batch_code) }}" class="btn btn-primary ">Post Record <i class="bx bxs-check-circle"></i> </a>
                                <a href="{{ route("discard-lead-record", $record->batch_code) }}" class="btn btn-danger ">Discard Record <i class="bx bxs-trash"></i> </a>
                            </div>
                        @endif
                    </div>
                    <div class="col-xl-12 col-md-12">
                        <div class="card">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">  Review Bulk Import</h4>
                                        <p>Kindly review this bulk action before posting. </p>
                                        <div class="table-responsive mt-3">
                                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                                <thead>
                                                <tr>
                                                    <th class="">#</th>
                                                    <th class="wd-15p">Date</th>
                                                    <th class="wd-15p">First Name</th>
                                                    <th class="wd-15p">Last Name</th>
                                                    <th class="wd-15p">Email</th>
                                                    <th class="wd-15p">Mobile No.</th>
                                                    <th class="wd-15p">Address</th>
                                                    @if($record->status == 0)
                                                        <th class="wd-15p">Action</th>
                                                    @endif
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php $index = 1; @endphp

                                                @foreach($record->getBulkImportDetails as $key=> $item)
                                                    <tr class="{{ $item->gender == 1 ? 'table-success' : 'table-secondary' }}">
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $item->entry_date ?? ''}}</td>
                                                        <td>{{ $item->first_name ?? '' }}</td>
                                                        <td>{{ $item->last_name ?? '' }}</td>
                                                        <td>{{ $item->email ?? '' }}</td>
                                                        <td>{{ $item->phone ?? '' }}</td>
                                                        <td>{{ $item->address ?? '' }}</td>
                                                        @if($record->status == 0)
                                                            <td>
                                                                <a class="text-danger" href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#deleteRecordModal_{{$item->id}}"><i class="bx bx-trash text-danger"></i></a>
                                                                <div class="modal fade" id="deleteRecordModal_{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header" >
                                                                                <h4 class="modal-title">Are You Sure?</h4>
                                                                                <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form autocomplete="off" action="#" method="post">
                                                                                    @csrf
                                                                                    <div class="form-group mt-1">
                                                                                        <p>This action cannot be undone. Are you sure you want to delete this record?</p>
                                                                                    </div>
                                                                                    <div class="form-group d-flex justify-content-center mt-3">
                                                                                        <div class="btn-group">
                                                                                            <a href="{{ route('delete-lead-record', $item->id) }}" class="btn btn-danger  waves-effect waves-light">Delete <i class="bx bx-check-circle"></i> </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endif
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
    </div>


@endsection

@section('extra-scripts')

@endsection
