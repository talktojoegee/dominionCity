@extends('layouts.master-layout')
@section('current-page')
     Bulk Import Details
@endsection
@section('extra-styles')

@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')

    <div class="container-fluid">
        <div class="row">
            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-check-all me-2"></i>
                    {!! session()->get('success') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
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
                                                <td>{{ $record->getImportedBy->first_name ?? ''  }} {{ $record->getImportedBy->last_name ?? ''  }} {{ $record->getImportedBy->other_names ?? ''  }}</td>
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
                                                <td>{{ $record->bcim_batch_code ?? ''  }}</td>
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
                                                <th scope="row">Month :</th>
                                                <td>{{ date("F", strtotime($record->bcim_month)) ?? ''  }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Status :</th>
                                                <td>
                                                    @switch($record->bcim_status)
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
                                            <tr>
                                                <th scope="row">Year :</th>
                                                <td>{{ $record->bcim_year ?? ''  }}</td>
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
                                                <td>{{ $record->bcim_narration ?? ''  }}</td>
                                            </tr>
                                            <tr class="table-secondary mt-3">
                                                <td> <strong>Total Debits: </strong>{{ number_format($record->getBulkImportDetails->where("bcid_transaction_type", 2)->count()) }}</td>
                                                <td>{{ number_format($record->getBulkImportDetails->where("bcid_transaction_type", 2)->sum("bcid_debit"),2) }}</td>
                                            </tr>
                                            <tr class="table-secondary">
                                                <td> <strong>Total Credits:</strong> {{ number_format($record->getBulkImportDetails->where("bcid_transaction_type", 1)->count()) }}</td>
                                                <td>{{ number_format($record->getBulkImportDetails->where("bcid_transaction_type", 1)->sum("bcid_credit"),2) }}</td>
                                            </tr>
                                            <tr class="table-secondary">
                                                <td> <strong>Balance:</strong></td>
                                                <td>{{ number_format($record->getBulkImportDetails->where("bcid_transaction_type", 1)->sum("bcid_credit") - $record->getBulkImportDetails->where("bcid_transaction_type", 2)->sum("bcid_debit"),2 ) }}</td>
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
                    @if($record->bcim_status == 0)
                        <div class="btn-group">
                            <a href="{{ route("post-record", $record->bcim_batch_code) }}" class="btn btn-primary ">Post Record <i class="bx bxs-check-circle"></i> </a>
                            <a href="{{ route("discard-record", $record->bcim_batch_code) }}" class="btn btn-danger ">Discard Record <i class="bx bxs-trash"></i> </a>
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
                                            <th class="wd-15p">Debit</th>
                                            <th class="wd-15p">Credit</th>
                                            <th class="wd-15p">Category</th>
                                            <th class="wd-15p">Narration</th>
                                            @if($record->bcim_status == 0)
                                                <th class="wd-15p">Action</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $index = 1; @endphp

                                        @foreach($record->getBulkImportDetails as $key=> $item)
                                            <tr class="{{ $item->bcid_transaction_type == 1 ? 'table-success' : 'table-danger' }}">
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $item->bcid_transaction_date ?? ''}}</td>
                                                <td>{{ number_format($item->bcid_debit ?? 0) ?? '' }}</td>
                                                <td>{{ number_format($item->bcid_credit ?? 0) ?? '' }}</td>
                                                <td>{{ $item->getCategory->tc_name ?? '' }}</td>
                                                <td>{{ $item->bcid_narration ?? '' }}</td>
                                                @if($record->bcim_status == 0)
                                                <td>
                                                   <a class="text-danger" href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#deleteRecordModal_{{$item->bcid_id}}"><i class="bx bx-trash text-danger"></i></a>
                                                    <div class="modal fade" id="deleteRecordModal_{{$item->bcid_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
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
                                                                                <a href="{{ route("delete-record", $item->bcid_id) }}" class="btn btn-danger  waves-effect waves-light">Delete <i class="bx bx-check-circle"></i> </a>
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
                                        <tr class="table-secondary mt-3">
                                            <td colspan="4"> <strong>Total Debits: </strong>{{ number_format($record->getBulkImportDetails->where("bcid_transaction_type", 2)->count()) }}</td>
                                            <td colspan="3">{{ number_format($record->getBulkImportDetails->where("bcid_transaction_type", 2)->sum("bcid_debit"),2) }}</td>
                                        </tr>
                                        <tr class="table-secondary">
                                            <td colspan="4"> <strong>Total Credits:</strong> {{ number_format($record->getBulkImportDetails->where("bcid_transaction_type", 1)->count()) }}</td>
                                            <td colspan="3">{{ number_format($record->getBulkImportDetails->where("bcid_transaction_type", 1)->sum("bcid_credit"),2) }}</td>
                                        </tr>
                                        <tr class="table-secondary">
                                            <td colspan="4"> <strong>Balance:</strong></td>
                                            <td colspan="3">{{ number_format($record->getBulkImportDetails->where("bcid_transaction_type", 1)->sum("bcid_credit") - $record->getBulkImportDetails->where("bcid_transaction_type", 2)->sum("bcid_debit"),2 ) }}</td>
                                        </tr>

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

@endsection

@section('extra-scripts')

@endsection
