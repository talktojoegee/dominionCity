@extends('layouts.master-layout')
@section('current-page')
    Expense
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
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    @can('record-expenses')
                    <div class="card-header">
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewProduct" class="btn btn-danger  mb-3">Record Expense <i class="bx bx bx-highlight"></i> </a>
                    </div>
                    @endcan
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title"> Outflow</h4>
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
                                            <div class="col-xxl-3 col-sm-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row mb-1">
                                                            <div class="col">
                                                                <p class="mb-2">Expenses</p>
                                                                <h5 class="mb-0 number-font">{{env('APP_CURRENCY')}}{{number_format($income->sum('cashbook_debit'),2)}}</h5>
                                                            </div>
                                                            <div class="col-auto mb-0">
                                                                <div class="dash-icon text-orange"> <i class="bx bxs-receipt text-success fs-22"></i></div>
                                                            </div>
                                                        </div>
                                                        <span class="fs-12 text-success"> <strong>Overall</strong> </span>
                                                        <span class="text-muted fs-12 ms-0 mt-1">Expense </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-sm-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row mb-1">
                                                            <div class="col"> <p class="mb-2">Expense</p><h5 class="mb-0 number-font">{{env('APP_CURRENCY')}}{{number_format($lastMonth->sum('cashbook_debit'),2)}}</h5> </div>
                                                            <div class="col-auto mb-0">
                                                                <div class="dash-icon text-secondary1"> <i class="bx bxs-receipt text-warning fs-22"></i> </div>
                                                            </div>
                                                        </div>
                                                        <span class="fs-12 text-warning"> <strong>Last Month's</strong>  </span>
                                                        <span class="text-muted fs-12 ms-0 mt-1">Expense </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-sm-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row mb-1">
                                                            <div class="col"> <p class="mb-2">Expense</p>
                                                                <h5 class="mb-0 number-font">{{env('APP_CURRENCY')}}{{number_format($thisMonth->sum('cashbook_debit'),2)}}</h5>
                                                            </div>
                                                            <div class="col-auto mb-0">
                                                                <div class="dash-icon text-secondary"> <i class="bx bxs-receipt text-primary fs-22"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="fs-12 text-primary"> <strong>This Month's</strong>  </span>
                                                        <span class="text-muted fs-12 ms-0 mt-1">Expense </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-sm-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row mb-1">
                                                            <div class="col">
                                                                <p class="mb-2">Expense</p>
                                                                <h5 class="mb-0 number-font">{{env('APP_CURRENCY')}}{{number_format($thisWeek->sum('cashbook_debit'),2)}}</h5>
                                                            </div>
                                                            <div class="col-auto mb-0">
                                                                <div class="dash-icon text-warning"> <i class="bx bxs-receipt text-info fs-22"></i> </div>
                                                            </div>
                                                        </div>
                                                        <span class="fs-12 text-info"> <strong>This Week's</strong>  </span>
                                                        <span class="text-muted fs-12 ms-0 mt-1">Expense </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">

                                            <h4 class="card-title">Domestic Transaction log</h4>
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
                                                                <th class="wd-15p">Date</th>
                                                                <th class="wd-15p">Account</th>
                                                                <th class="wd-15p">Amount({{env('APP_CURRENCY')}})</th>
                                                                <th class="wd-15p">Payment Method</th>
                                                                <th class="wd-15p">Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php $index = 1; @endphp
                                                            @foreach($income as $sale)
                                                                <tr>
                                                                    <td>{{$index++}}</td>
                                                                    <td>{{date('d M, Y', strtotime($sale->cashbook_transaction_date))}}</td>
                                                                    <td>{{$sale->getAccount->cba_name ?? '' }} ({{$sale->getAccount->cba_account_no ?? '' }})</td>
                                                                    <td style="text-align: right;">{{number_format($sale->cashbook_debit ?? 0,2)}}</td>
                                                                    <td>
                                                                        @switch($sale->cashbook_payment_method)
                                                                            @case(1)
                                                                            <span class="badge rounded-pill bg-success">Cash</span>
                                                                            @break
                                                                            @case(2)
                                                                            <span class="badge rounded-pill bg-info">Bank Transfer</span>
                                                                            @break
                                                                            @case(3)
                                                                            <span class="badge rounded-pill bg-warning">Cheque</span>
                                                                            @break
                                                                            @case(4)
                                                                            <span class="badge rounded-pill bg-secondary">Internet</span>
                                                                            @break
                                                                        @endswitch
                                                                    </td>
                                                                    <td>
                                                                        <div class="btn-group">
                                                                            <i class="bx bx-dots-vertical dropdown-toggle text-warning" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                                                            <div class="dropdown-menu">
                                                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-target="#viewSales_{{$sale->cashbook_id}}" data-bs-toggle="modal"> <i class="bx bxs-book-open"></i> View</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal right fade" id="viewSales_{{$sale->cashbook_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" style="width: 900px;">
                                                                            <div class="modal-dialog modal-lg w-100" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header" >
                                                                                        <h6 class="modal-title text-uppercase" style="text-align: center;" id="myModalLabel2">Record Details</h6>
                                                                                        <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>

                                                                                    <div class="modal-body">
                                                                                        <div class="row">
                                                                                            <div class="col-lg-12">
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                        <div class="invoice-title">
                                                                                                            <h4 class="float-end font-size-16">Transaction Ref.{{$sale->cashbook_ref_code ?? '' }}</h4>
                                                                                                            <div class="mb-4">
                                                                                                                <img src="{{url('storage/'.Auth::user()->getUserOrganization->logo)}}" alt="logo" height="20">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <hr>
                                                                                                        <div class="row">
                                                                                                            <div class="col-sm-6">
                                                                                                                <address>
                                                                                                                    <strong>Entry By:</strong><br>
                                                                                                                    {{$sale->getEntryBy->first_name ?? '' }} {{$sale->getEntryBy->last_name ?? '' }}<br>
                                                                                                                    {{$sale->getEntryBy->email ?? '' }}<br>
                                                                                                                    {{$sale->getEntryBy->mobile_no ?? '' }}<br>
                                                                                                                    {{$sale->getEntryBy->address ?? '' }}
                                                                                                                    {{ date('d M, Y h:ia', strtotime($sale->created_at)) }}
                                                                                                                </address>
                                                                                                            </div>
                                                                                                            <div class="col-sm-6 text-sm-end">
                                                                                                                <address>
                                                                                                                    <strong>Branch:</strong><br>
                                                                                                                    {{$sale->getBranch->cb_name ?? ''  }}<br>
                                                                                                                    {{$sale->getBranch->cb_mobile_no ?? ''  }}<br>
                                                                                                                    {{$sale->getBranch->cb_email ?? ''  }}<br>
                                                                                                                    {{$sale->getBranch->cb_address ?? ''  }}<br>
                                                                                                                </address>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="row">
                                                                                                            <div class="col-sm-6 mt-3">
                                                                                                                <address>
                                                                                                                    <strong>Payment Method:</strong><br>
                                                                                                                    @switch($sale->cashbook_payment_method)
                                                                                                                        @case(1)
                                                                                                                        <span class="badge rounded-pill bg-success">Cash</span>
                                                                                                                        @break
                                                                                                                        @case(2)
                                                                                                                        <span class="badge rounded-pill bg-info">Bank Transfer</span>
                                                                                                                        @break
                                                                                                                        @case(3)
                                                                                                                        <span class="badge rounded-pill bg-warning">Cheque</span>
                                                                                                                        @break
                                                                                                                        @case(4)
                                                                                                                        <span class="badge rounded-pill bg-secondary">Internet</span>
                                                                                                                        @break
                                                                                                                    @endswitch
                                                                                                                </address>
                                                                                                            </div>
                                                                                                            <div class="col-sm-6 mt-3 text-sm-end">
                                                                                                                <address>
                                                                                                                    <strong>Date:</strong><br>
                                                                                                                    {{date('M d, Y h:ia', strtotime($sale->cashbook_transaction_date))}}<br><br>
                                                                                                                </address>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="py-2 mt-3">
                                                                                                            <h3 class="font-size-15 fw-bold">Entry Line</h3>
                                                                                                        </div>
                                                                                                        <div class="table-responsive">
                                                                                                            <table class="table table-nowrap">
                                                                                                                <thead>
                                                                                                                <tr class="text-center">
                                                                                                                    <th style="width: 70px;">Branch</th>
                                                                                                                    <th>Category</th>
                                                                                                                    <th>Payment Method</th>
                                                                                                                    <th class="text-end">Transaction Ref.</th>
                                                                                                                    <th class="text-end">Amount</th>
                                                                                                                </tr>
                                                                                                                </thead>
                                                                                                                <tbody>
                                                                                                                <tr>
                                                                                                                    <td>{{$sale->getBranch->cb_name ?? '' }}</td>
                                                                                                                    <td>{{$sale->getCategory->tc_name ?? '' }}</td>
                                                                                                                    <td>
                                                                                                                        @switch($sale->cashbook_payment_method)
                                                                                                                            @case(1)
                                                                                                                            <span class="badge rounded-pill bg-success">Cash</span>
                                                                                                                            @break
                                                                                                                            @case(2)
                                                                                                                            <span class="badge rounded-pill bg-info">Bank Transfer</span>
                                                                                                                            @break
                                                                                                                            @case(3)
                                                                                                                            <span class="badge rounded-pill bg-warning">Cheque</span>
                                                                                                                            @break
                                                                                                                            @case(4)
                                                                                                                            <span class="badge rounded-pill bg-secondary">Internet</span>
                                                                                                                            @break
                                                                                                                        @endswitch
                                                                                                                    </td>
                                                                                                                    <td>{{$sale->cashbook_ref_code ?? '' }}</td>
                                                                                                                    <td class="text-end">{{ $sale->getCurrency->symbol ?? 'N' }}{{number_format($sale->cashbook_debit,2)}}</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td colspan="5" class="border-0 text-start">
                                                                                                                        <strong>Amount in words: </strong>
                                                                                                                        <?php
                                                                                                                        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                                                                                                                        $f->setTextAttribute(NumberFormatter::DEFAULT_RULESET, "%spellout-numbering-verbose");
                                                                                                                        echo ucfirst($f->format($sale->cashbook_debit)).' '.strtolower($sale->getCurrency->name);
                                                                                                                        ?>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td colspan="5">
                                                                                                                        <p class="text-wrap"> <strong>Narration:</strong> {{$sale->cashbook_narration ?? '' }}</p>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </div>
                                                                                                        <div class="d-print-none">
                                                                                                            <div class="float-end">
                                                                                                                @if(!is_null($sale->getTransactionAttachment($sale->cashbook_id)))
                                                                                                                    <a href="{{ route('download-attachment', $sale->getTransactionAttachment($sale->cashbook_id)->cba_attachment) }}" class="btn btn-secondary waves-effect waves-light me-1"><i class="fa fa-download"></i> Download Attachment</a>
                                                                                                                @endif

                                                                                                                <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i> Print</a>
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
                                                    <div class="table-responsive mt-3">
                                                        <table id="datatable1" class="table table-bordered dt-responsive  nowrap w-100">
                                                            <thead>
                                                            <tr>
                                                                <th class="">#</th>
                                                                <th class="wd-15p">Date</th>
                                                                <th class="wd-15p">Account</th>
                                                                <th class="wd-15p">Amount</th>
                                                                <th class="wd-15p">Payment Method</th>
                                                                <th class="wd-15p">Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php $index = 1; @endphp
                                                            @foreach($fxIncomes as $fx)
                                                                <tr>
                                                                    <td>{{$index++}}</td>
                                                                    <td>{{date('d M, Y', strtotime($fx->cashbook_transaction_date))}}</td>
                                                                    <td>{{$fx->getAccount->cba_name ?? '' }} ({{$fx->getAccount->cba_account_no ?? '' }})</td>
                                                                    <td style="text-align: right;">{{ $fx->getCurrency->code ?? '' }} - {{ $fx->getCurrency->symbol ?? '' }}{{number_format($fx->cashbook_debit ?? 0,2)}}</td>
                                                                    <td>
                                                                        @switch($fx->cashbook_payment_method)
                                                                            @case(1)
                                                                            Cash
                                                                            @break
                                                                            @case(2)
                                                                            Bank Transfer
                                                                            @break
                                                                            @case(3)
                                                                            Cheque
                                                                            @break
                                                                            @case(4)
                                                                            Internet
                                                                            @break
                                                                        @endswitch
                                                                    </td>
                                                                    <td>
                                                                        <div class="btn-group">
                                                                            <i class="bx bx-dots-vertical dropdown-toggle text-warning" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                                                            <div class="dropdown-menu">
                                                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-target="#viewSalesFx_{{$fx->cashbook_id}}" data-bs-toggle="modal"> <i class="bx bxs-book-open"></i> View</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal right fade" id="viewSalesFx_{{$fx->cashbook_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" style="width: 900px;">
                                                                            <div class="modal-dialog modal-lg w-100" role="document">
                                                                                <div class="modal-content" id="printArea">
                                                                                    <div class="modal-header" >
                                                                                        <h6 class="modal-title text-uppercase" style="text-align: center;" id="myModalLabel2">Record Details</h6>
                                                                                        <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>

                                                                                    <div class="modal-body">
                                                                                        <div class="row">
                                                                                            <div class="col-lg-12">
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                            <div class="invoice-title">
                                                                                                                <h4 class="float-end font-size-16">Transaction Ref.{{$fx->cashbook_ref_code ?? '' }}</h4>
                                                                                                                <div class="mb-4">
                                                                                                                    <img src="{{url('storage/'.Auth::user()->getUserOrganization->logo)}}" alt="logo" height="20">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <hr>
                                                                                                            <div class="row">
                                                                                                                <div class="col-sm-6">
                                                                                                                    <address>
                                                                                                                        <strong>Entry By:</strong><br>
                                                                                                                        {{$fx->getEntryBy->first_name ?? '' }} {{$fx->getEntryBy->last_name ?? '' }}<br>
                                                                                                                        {{$fx->getEntryBy->email ?? '' }}<br>
                                                                                                                        {{$fx->getEntryBy->mobile_no ?? '' }}<br>
                                                                                                                        {{$fx->getEntryBy->address ?? '' }}
                                                                                                                        {{ date('d M, Y h:ia', strtotime($fx->created_at)) }}
                                                                                                                    </address>
                                                                                                                </div>
                                                                                                                <div class="col-sm-6 text-sm-end">
                                                                                                                    <address>
                                                                                                                        <strong>Branch:</strong><br>
                                                                                                                        {{$fx->getBranch->cb_name ?? ''  }}<br>
                                                                                                                        {{$fx->getBranch->cb_mobile_no ?? ''  }}<br>
                                                                                                                        {{$fx->getBranch->cb_email ?? ''  }}<br>
                                                                                                                        {{$fx->getBranch->cb_address ?? ''  }}<br>
                                                                                                                    </address>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="row">
                                                                                                                <div class="col-sm-6 mt-3">
                                                                                                                    <address>
                                                                                                                        <strong>Payment Method:</strong><br>
                                                                                                                        @switch($fx->cashbook_payment_method)
                                                                                                                            @case(1)
                                                                                                                            Cash
                                                                                                                            @break
                                                                                                                            @case(2)
                                                                                                                            Bank Transfer
                                                                                                                            @break
                                                                                                                            @case(3)
                                                                                                                            Cheque
                                                                                                                            @break
                                                                                                                            @case(4)
                                                                                                                            Internet
                                                                                                                            @break
                                                                                                                        @endswitch
                                                                                                                    </address>
                                                                                                                </div>
                                                                                                                <div class="col-sm-6 mt-3 text-sm-end">
                                                                                                                    <address>
                                                                                                                        <strong>Date:</strong><br>
                                                                                                                        {{date('M d, Y h:ia', strtotime($fx->cashbook_transaction_date))}}<br><br>
                                                                                                                    </address>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="py-2 mt-3">
                                                                                                                <h3 class="font-size-15 fw-bold">Entry Line</h3>
                                                                                                            </div>
                                                                                                            <div class="table-responsive">
                                                                                                                <table class="table table-nowrap">
                                                                                                                    <thead>
                                                                                                                    <tr>
                                                                                                                        <th style="width: 70px;">Branch</th>
                                                                                                                        <th>Category</th>
                                                                                                                        <th>Payment Method</th>
                                                                                                                        <th class="text-end">Transaction Ref.</th>
                                                                                                                        <th class="text-end">Amount</th>
                                                                                                                    </tr>
                                                                                                                    </thead>
                                                                                                                    <tbody>
                                                                                                                    <tr>
                                                                                                                        <td>{{$fx->getBranch->cb_name ?? '' }}</td>
                                                                                                                        <td>{{$fx->getCategory->tc_name ?? '' }}</td>
                                                                                                                        <td>
                                                                                                                            @switch($fx->cashbook_payment_method)
                                                                                                                                @case(1)
                                                                                                                                Cash
                                                                                                                                @break
                                                                                                                                @case(2)
                                                                                                                                Bank Transfer
                                                                                                                                @break
                                                                                                                                @case(3)
                                                                                                                                Cheque
                                                                                                                                @break
                                                                                                                                @case(4)
                                                                                                                                Internet
                                                                                                                                @break
                                                                                                                            @endswitch
                                                                                                                        </td>
                                                                                                                        <td>{{$fx->cashbook_ref_code ?? '' }}</td>
                                                                                                                        <td class="text-end">{{ $fx->getCurrency->symbol ?? 'N' }}{{number_format($fx->cashbook_credit,2)}}</td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td colspan="5" class="border-0 text-start">
                                                                                                                            <strong>Amount in words: </strong>
                                                                                                                            <?php
                                                                                                                            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                                                                                                                            $f->setTextAttribute(NumberFormatter::DEFAULT_RULESET, "%spellout-numbering-verbose");
                                                                                                                            echo ucfirst($f->format($fx->cashbook_credit)).' '.strtolower($fx->getCurrency->name);
                                                                                                                            ?>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td colspan="5">
                                                                                                                            <p class="text-wrap"> <strong>Narration:</strong> {{$fx->cashbook_narration ?? '' }}</p>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    </tbody>
                                                                                                                </table>
                                                                                                            </div>
                                                                                                        <div class="d-print-none">
                                                                                                            <div class="float-end">
                                                                                                                @if(!is_null($fx->getTransactionAttachment($fx->cashbook_id)))
                                                                                                                    <a href="{{ route('download-attachment', $fx->getTransactionAttachment($fx->cashbook_id)->cba_attachment) }}" class="btn btn-secondary waves-effect waves-light me-1"><i class="fa fa-download"></i> Download Attachment</a>
                                                                                                                @endif
                                                                                                                <a href="javascript:void(0);" onclick="generatePDF()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i> Print</a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal right fade" id="addNewProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" style="width: 900px;">
        <div class="modal-dialog modal-lg w-100" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <h6 class="modal-title text-uppercase" style="text-align: center;" id="myModalLabel2">Record Transaction</h6>
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form autocomplete="off" action="{{route('record-income')}}" id="createIncomeForm" data-parsley-validate="" method="post" enctype="multipart/form-data">
                        @csrf
                       <div class="row mb-3">
                           <div class="form-group mt-1 col-md-6">
                               <label for=""> Account</label>
                               <select name="account" id="account" class="form-control">
                                   <option disabled selected>--Select an account--</option>
                                   @foreach($accounts as $account)
                                       <option value="{{$account->cba_id}}">{{$account->cba_name ?? '' }} </option>
                                   @endforeach
                               </select>
                               @error('account') <i class="text-danger">{{$message}}</i>@enderror
                           </div>
                           <div class="form-group mt-1 col-md-6 ">
                               <label for="">Category <span class="text-danger">*</span></label>
                               <select name="category"  class="form-control">
                                   <option disabled selected>-- Select category --</option>
                                   @foreach($categories as $category)
                                       <option value="{{$category->tc_id}}">{{$category->tc_name ?? '' }} </option>
                                   @endforeach
                               </select>
                               @error('category') <i class="text-danger">{{$message}}</i>@enderror
                               <input type="hidden" name="transactionType" value="2">
                           </div>
                       </div>
                        <div class="row mb-3">
                            <div class="form-group mt-1 col-md-6">
                                <label for=""> Date<span class="text-danger">*</span></label>
                                <input type="date" value="{{date('Y-m-d', strtotime(now()))}}" name="date" class="form-control">
                                @error('date') <i class="text-danger">{{$message}}</i>@enderror
                            </div>

                            <div class="form-group mt-1 col-md-6">
                                <label for="">Payment Method <span class="text-danger">*</span></label> <br>
                                <select name="paymentMethod"  class="form-control ">
                                    <option value="1">Cash</option>
                                    <option value="2">Bank Transfer</option>
                                    <option value="3">Cheque</option>
                                    <option value="4">Internet</option>
                                </select>
                                @error('paymentMethod') <i class="text-danger">{{$message}}</i>@enderror
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="form-group mt-1 col-md-6">
                                <label for="">Amount <span class="text-danger">*</span></label>
                                <input type="text" placeholder="Enter amount" name="amount" value="{{old('amount')}}" class="form-control number">
                                @error('amount') <i class="text-danger">{{$message}}</i>@enderror
                            </div>
                            <div class="form-group mt-1 col-md-6">
                                <label for=""> Currency</label>
                                <select name="currency" id="currency" class="form-control">
                                    <option disabled selected>--Select currency--</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->id}}" {{ $currency->symbol === env('APP_CURRENCY') ? 'selected' : null }}>{{$currency->name ?? '' }}( {{ $currency->code ?? '' }} {{$currency->symbol ?? '' }}) </option>
                                    @endforeach
                                </select>
                                @error('currency') <i class="text-danger">{{$message}}</i>@enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group mt-1 col-md-6">
                                <label for="">Attachment <small>(Optional)</small></label> <br>
                                <input type="file" multiple name="attachments[]" class="form-control-file">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group mt-1 col-md-12">
                                <label for="">Narration</label> <br>
                                <textarea name="narration" id="narration" style="resize: none;" placeholder="Type narration here..." class="form-control">{{old('narration')}}</textarea>
                                @error('narration') <i class="text-danger">{{$message}}</i>@enderror
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-center mt-3">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary  waves-effect waves-light">Submit Record <i class="bx bxs-right-arrow"></i> </button>
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
