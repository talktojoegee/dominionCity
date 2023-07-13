@extends('layouts.master-layout')
@section('current-page')
    Cashbook Report
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
            @if($search == 0)
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="mdi mdi-check-all me-2"></i>
                        {!! session()->get('success') !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @include('cashbook._search-form')
            @else
                @include('cashbook._search-form')
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title"> Cashbook Report</h4>
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                <span class="d-none d-sm-block">{{$defaultCurrency->name ?? '' }} ({{$defaultCurrency->symbol ?? '' }}) Transactions</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                <span class="d-none d-sm-block">FX Transactions</span>
                                            </a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content p-3 text-muted">
                                        <div class="tab-pane active" id="home1" role="tabpanel">
                                            <div class="row mt-4">
                                                <div class="col-md-12 col-lg-12">
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
                                                            <div class="col-xxl-4 col-sm-6">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="row mb-1">
                                                                            <div class="col">
                                                                                <p class="mb-2">Total Expenses</p>
                                                                                <h3 class="mb-0 number-font text-warning">{{$defaultCurrency->symbol ?? '' }}{{ number_format( $transactions->sum('cashbook_debit') ,2) }}</h3>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-4 col-sm-6">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="row mb-1">
                                                                            <div class="col"> <p class="mb-2">Total Income</p>
                                                                                <h3 class="mb-0 number-font text-success">{{$defaultCurrency->symbol ?? '' }}{{number_format($transactions->sum('cashbook_credit'),2) }}</h3>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xxl-4 col-sm-6">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="row mb-1">
                                                                            <div class="col"> <p class="mb-2"> Balance</p>
                                                                                <h3 class="mb-0 number-font text-info">{{$defaultCurrency->symbol ?? '' }}{{ number_format($transactions->sum('cashbook_credit') - $transactions->sum('cashbook_debit') ,2) ?? 0 }}</h3>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    <form action="#" method="#">
                                                        @csrf
                                                        <input type="hidden" name="collectionFrom" value="{{$from}}">
                                                        <input type="hidden" name="collectionTo" value="{{$to}}">
                                                        <p class="text-center">Showing cashbook report between <code>{{date('d M, Y', strtotime($from))}}</code> and <code>{{date('d M, Y', strtotime($to))}}</code></p>
                                                        <div class="table-responsive mt-3">
                                                            <table id="complex-header" class="table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="complex-header_info" style="width: 100%; margin:0px auto;">
                                                                <thead style="position: sticky;top: 0">
                                                                <tr role="row">
                                                                    <th class="sorting_asc text-left text-uppercase header" tabindex="0">#</th>
                                                                    <th class="sorting_asc text-left text-uppercase header" tabindex="0">Date</th>
                                                                    <th class="sorting_asc text-left text-uppercase header" tabindex="0">Account</th>
                                                                    <th class="sorting_asc text-left text-uppercase header" tabindex="0">Category</th>
                                                                    <th class="sorting_asc text-left text-uppercase header" tabindex="0">Debit</th>
                                                                    <th class="sorting_asc text-left text-uppercase header" tabindex="0">Credit</th>
                                                                    <th class="sorting_asc text-left text-uppercase header" tabindex="0">Balance</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($transactions as $key=>$trans)
                                                                    <tr role="row" class="odd bg-secondary text-white ">
                                                                        <td class="text-left">{{ $key + 1 }}</td>
                                                                        <td class="text-left">{{ date('d M, Y h:ia', strtotime($trans->cashbook_transaction_date)) }}</td>
                                                                        <td class="text-left">{{ $trans->getAccount->cba_name ?? '' }}
                                                                        <td class="text-left">{{ $trans->getCategory->tc_name ?? '' }}
                                                                        </td>
                                                                        <td class="text-left" style="text-align: right">{{ number_format($trans->cashbook_debit,2) }}</td>
                                                                        <td class="text-left" style="text-align: right">{{ number_format($trans->cashbook_credit,2) }}</td>
                                                                        <td class="text-left" style="text-align: right">
                                                                            <?php
                                                                                $diff = $trans->cashbook_credit - $trans->cashbook_debit;
                                                                                $balance = $balance + $diff;
                                                                            ?>
                                                                            {{ number_format($balance,2) }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach

                                                            </table>
                                                        </div>
                                                    </form>

                                                </div>

                                            </div>
                                        </div>
                                        <div class="tab-pane" id="profile1" role="tabpanel">
                                            <div class="card-body">

                                                <h4 class="card-title">FX Transaction log</h4>
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
            @endif

        </div>
    </div>

@endsection

@section('extra-scripts')
    <script src="/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script src="/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <script src="/assets/js/pages/datatables.init.js"></script>
    <script src="/assets/libs/select2/js/select2.min.js"></script>
    <script src="/assets/js/pages/form-advanced.init.js"></script>
    <script src="/js/parsley.js"></script>
    {{--<script src="/js/select2.min.js"></script>--}}
    <script src="/js/simple.money.format.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.0/html2pdf.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.js-example-basic-single').select2();
            $('#createIncomeForm').parsley().on('field:validated', function() {
                let ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            })
                .on('form:submit', function() {
                    return true;
                });
        });
        function generatePDF(){
            var element = document.getElementById('printArea');
            html2pdf(element,{
                margin:       10,
                filename:     "Inflow_"+".pdf",
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, logging: true, dpi: 192, letterRendering: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            });
        }
    </script>
@endsection
