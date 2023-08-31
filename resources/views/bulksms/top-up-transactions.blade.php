@extends('layouts.master-layout')
@section('current-page')
    Top up Transactions
@endsection
@section('extra-styles')
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

@endsection
@section('breadcrumb-action-btn')
    Top up Transactions
@endsection

@section('main-content')
    @if(session()->has('success'))
        <div class="row" role="alert">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-all me-2"></i>

                            {!! session()->get('success') !!}

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-sm-6 pe-0 ps-0">
            <div class="card">
                <div class="card-body">
                    <div class="card-body text-center">
                        <h6 class="mb-0">Current Balance</h6>
                        <h5 class="mb-1 mt-2 number-font">
                            <span class="counter text-success">₦{{ number_format(Auth::user()->getUserAccount->sum('credit') - Auth::user()->getUserAccount->sum('debit'),2)  }}</span>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="wd-15p">Date</th>
                                <th class="wd-15p">Reference</th>
                                <th class="wd-15p">Amount</th>
                                <th class="wd-15p">Transaction</th>
                                <th class="wd-15p">Narration</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $serial = 1; @endphp
                            @foreach(Auth::user()->getUserAccount as $transaction)
                                <tr>
                                    <td>{{$serial++}}</td>
                                    <td>{{date('d M, Y', strtotime($transaction->created_at))}}</td>
                                    <td>{{ strtoupper($transaction->ref_no)  }}</td>
                                    <td class="text-right">{{$transaction->credit == 0 ? '₦'.number_format($transaction->debit,2) : '₦'.number_format($transaction->credit,2) }}</td>
                                    <td>{!! $transaction->unit_credit == 0 ? "<label class='text-danger'>Debit</label>" : "<label class='text-success'>Credit</label>" !!}</td>
                                    <td>{{$transaction->narration ?? '' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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

    <!-- Datatable init js -->
    <script src="/assets/js/pages/datatables.init.js"></script>



@endsection
