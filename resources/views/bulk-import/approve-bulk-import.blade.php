@extends('layouts.master-layout')
@section('current-page')
    Approve Bulk Import
@endsection
@section('extra-styles')
    <link href="{{asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/parsley.css" rel="stylesheet" type="text/css" />
    <style>
        .text-danger{
            color: #ff0000 !important;
        }
    </style>
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
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title">  Approve Bulk Import</h4>
                                    <div class="table-responsive mt-3">
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th class="">#</th>
                                                <th class="wd-15p">Date</th>
                                                <th class="wd-15p">Account</th>
                                                <th class="wd-15p">Batch Code</th>
                                                <th class="wd-15p">Month</th>
                                                <th class="wd-15p">Year</th>
                                                <th class="wd-15p">Status</th>
                                                <th class="wd-15p">Total Records</th>
                                                <th class="wd-15p">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $index = 1; @endphp

                                            @foreach($records as $key=> $record)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ date('d M, Y', strtotime($record->created_at)) }}</td>
                                                    <td>{{ $record->getAccount->cba_name ?? '' }}</td>
                                                    <td>{{ $record->bcim_batch_code ?? '' }}</td>
                                                    <td>{{ date("F", strtotime($record->bcim_month)) }}</td>
                                                    <td>{{ $record->bcim_year ?? '' }}</td>
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
                                                    <td>{{ number_format($record->getBulkImportDetails->count() ?? 0) ?? '' }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <i class="bx bx-dots-vertical dropdown-toggle text-warning" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="{{ route("view-bulk-import", $record->bcim_batch_code) }}"> <i class="bx bx-book-open"></i> View </a>
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

@endsection

@section('extra-scripts')
    <script src="/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script src="/assets/js/pages/datatables.init.js"></script>
@endsection
