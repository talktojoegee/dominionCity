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
                @include('reports.cashbook._search-form')
            @else
                @include('reports.cashbook._search-form')
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
                                                                                <h3 class="mb-0 number-font text-warning">{{$defaultCurrency->symbol ?? '' }}{{ number_format( $transactions->where('cashbook_debit', '>', 0)->sum('cashbook_debit') ,2) }}</h3>
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
                                                                                <h3 class="mb-0 number-font text-success">{{$defaultCurrency->symbol ?? '' }}{{number_format($transactions->where('cashbook_credit', '>', 0)->sum('cashbook_credit'),2) }}</h3>
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
                                                                                <h3 class="mb-0 number-font text-info">{{$defaultCurrency->symbol ?? '' }}{{ number_format($transactions->where('cashbook_credit', '>', 0)->sum('cashbook_credit') - $transactions->where('cashbook_debit', '>', 0)->sum('cashbook_debit') ,2) ?? 0 }}</h3>
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
                                                        <p class="text-center">Showing cashbook report between <code>{{date('d M, Y', strtotime($from))}}</code> to <code>{{date('d M, Y', strtotime($to))}}</code></p>
                                                        <div class="table-responsive mt-3">
                                                            <table id="complex-header" class="table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="complex-header_info" style="width: 100%; margin:0px auto;">
                                                                <thead style="position: sticky;top: 0">
                                                                <tr role="row">
                                                                    <th class="sorting_asc text-left text-uppercase header" tabindex="0">S/No.</th>
                                                                    <th class="sorting_asc text-left text-uppercase header" tabindex="0">Date</th>
                                                                    <th class="sorting_asc text-left text-uppercase header" tabindex="0">Account</th>
                                                                    <th class="sorting_asc text-left text-uppercase header" tabindex="0">Category</th>
                                                                    <th class="sorting_asc text-left text-uppercase header" tabindex="0">Debit ({{$defaultCurrency->symbol ?? '' }})</th>
                                                                    <th class="sorting_asc text-left text-uppercase header" tabindex="0">Credit ({{$defaultCurrency->symbol ?? '' }})</th>
                                                                    <th class="sorting_asc text-left text-uppercase header" tabindex="0">Balance ({{$defaultCurrency->symbol ?? '' }})</th>
                                                                    <th class="sorting_asc text-left text-uppercase header" tabindex="0">#</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @php $serial = 1; @endphp
                                                                @foreach($transactions as $item =>$trans)
                                                                    <tr role="row" class="odd bg-secondary text-white ">
                                                                        <td class="text-left">{{ $serial++ }}</td>
                                                                        <td class="text-left">{{ date('d M, Y', strtotime($trans->cashbook_transaction_date)) }}</td>
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
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <i class="bx bx-dots-vertical dropdown-toggle text-warning" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                                                                <div class="dropdown-menu">
                                                                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-target="#cashbookModal_{{$trans->cashbook_id}}" data-bs-toggle="modal"> <i class="bx bxs-book-open text-info"></i> View</a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal right fade" id="cashbookModal_{{$trans->cashbook_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" style="width: 900px;">
                                                                                <div class="modal-dialog modal-lg w-100" role="document">
                                                                                    <div class="modal-content" id="printArea">
                                                                                        <div class="modal-header" >
                                                                                            <h6 class="modal-title text-uppercase" style="text-align: center;" id="myModalLabel2">Report Details</h6>
                                                                                            <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                        </div>

                                                                                        <div class="modal-body">
                                                                                            <div class="row">
                                                                                                <div class="col-lg-12">
                                                                                                    <div class="card">
                                                                                                        <div class="card-body">
                                                                                                            <div class="invoice-title">
                                                                                                                <h4 class="float-end font-size-16">Transaction Ref.{{$trans->cashbook_ref_code ?? '' }}</h4>
                                                                                                                <div class="mb-4">
                                                                                                                    <img src="{{url('storage/'.Auth::user()->getUserOrganization->logo)}}" alt="logo" height="20">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <hr>
                                                                                                            <div class="row">
                                                                                                                <div class="col-sm-6 text-muted">
                                                                                                                    <address>
                                                                                                                        <strong>Entry By:</strong><br>
                                                                                                                        {{$trans->getEntryBy->first_name ?? '' }} {{$trans->getEntryBy->last_name ?? '' }}<br>
                                                                                                                        {{$trans->getEntryBy->email ?? '' }}<br>
                                                                                                                        {{$trans->getEntryBy->mobile_no ?? '' }}<br>
                                                                                                                        {{$trans->getEntryBy->address ?? '' }}
                                                                                                                        {{ date('d M, Y h:ia', strtotime($trans->created_at)) }}
                                                                                                                    </address>
                                                                                                                </div>
                                                                                                                <div class="col-sm-6 text-sm-end text-muted">
                                                                                                                    <address>
                                                                                                                        <strong>Branch:</strong><br>
                                                                                                                        {{$trans->getBranch->cb_name ?? ''  }}<br>
                                                                                                                        {{$trans->getBranch->cb_mobile_no ?? ''  }}<br>
                                                                                                                        {{$trans->getBranch->cb_email ?? ''  }}<br>
                                                                                                                        {{$trans->getBranch->cb_address ?? ''  }}<br>
                                                                                                                    </address>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="row text-muted">
                                                                                                                <div class="col-sm-3 mt-3">
                                                                                                                    <address>
                                                                                                                        <strong>Account:</strong><br>
                                                                                                                        {{$trans->getAccount->cba_name ?? '' }}
                                                                                                                    </address>
                                                                                                                </div>
                                                                                                                <div class="col-sm-3 mt-3">
                                                                                                                    <address>
                                                                                                                        <strong>Payment Method:</strong><br>
                                                                                                                        @switch($trans->cashbook_payment_method)
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
                                                                                                                <div class="col-sm-3 mt-3 text-sm-end">
                                                                                                                    <address>
                                                                                                                        <strong>Transaction Date:</strong><br>
                                                                                                                        {{date('M d, Y h:ia', strtotime($trans->cashbook_transaction_date))}}<br><br>
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
                                                                                                                        <td>{{$trans->getBranch->cb_name ?? '' }}</td>
                                                                                                                        <td>{{$trans->getCategory->tc_name ?? '' }}</td>
                                                                                                                        <td>
                                                                                                                            @switch($trans->cashbook_payment_method)
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
                                                                                                                        <td>{{$trans->cashbook_ref_code ?? '' }}</td>
                                                                                                                        <td class="text-end">{{ $trans->getCurrency->symbol ?? 'N' }}{{number_format($trans->cashbook_transaction_type == 1 ? $trans->cashbook_credit : $trans->cashbook_debit,2)}}</td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td colspan="5" class="border-0 text-start">
                                                                                                                            <strong>Amount in words: </strong>
                                                                                                                            <?php
                                                                                                                            $amount = $trans->cashbook_transaction_type == 1 ? $trans->cashbook_credit : $trans->cashbook_debit;
                                                                                                                            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                                                                                                                            $f->setTextAttribute(NumberFormatter::DEFAULT_RULESET, "%spellout-numbering-verbose");
                                                                                                                            echo ucfirst($f->format($amount)).' '.strtolower($trans->getCurrency->name);
                                                                                                                            ?>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    <tr>
                                                                                                                        <td colspan="5">
                                                                                                                            <p class="text-wrap"> <strong>Narration:</strong> {{$trans->cashbook_narration ?? '' }}</p>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                    </tbody>
                                                                                                                </table>
                                                                                                            </div>
                                                                                                            <div class="d-print-none">
                                                                                                                <div class="float-end">
                                                                                                                    @if(!is_null($trans->getTransactionAttachment($trans->cashbook_id)))
                                                                                                                        <a href="{{ route('download-attachment', $trans->getTransactionAttachment($trans->cashbook_id)->cba_attachment) }}" class="btn btn-secondary waves-effect waves-light me-1"><i class="fa fa-download"></i> Download Attachment</a>
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

                                                            </table>
                                                        </div>
                                                    </form>

                                                </div>

                                            </div>
                                        </div>
                                        <div class="tab-pane" id="profile1" role="tabpanel">
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
                                                <form action="#" method="#">
                                                    @csrf
                                                    <input type="hidden" name="collectionFrom" value="{{$from}}">
                                                    <input type="hidden" name="collectionTo" value="{{$to}}">
                                                    <p class="text-center">Showing cashbook report between <code>{{date('d M, Y', strtotime($from))}}</code> to <code>{{date('d M, Y', strtotime($to))}}</code></p>
                                                    <div class="table-responsive mt-3">
                                                        <table id="complex-header" class="table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="complex-header_info" style="width: 100%; margin:0px auto;">
                                                            <thead style="position: sticky;top: 0">
                                                            <tr role="row">
                                                                <th class="sorting_asc text-left text-uppercase header" tabindex="0">S/No.</th>
                                                                <th class="sorting_asc text-left text-uppercase header" tabindex="0">Date</th>
                                                                <th class="sorting_asc text-left text-uppercase header" tabindex="0">Account</th>
                                                                <th class="sorting_asc text-left text-uppercase header" tabindex="0">Category</th>
                                                                <th class="sorting_asc text-left text-uppercase header" tabindex="0">Debit</th>
                                                                <th class="sorting_asc text-left text-uppercase header" tabindex="0">Credit</th>
                                                                <th class="sorting_asc text-left text-uppercase header" tabindex="0">#</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php $index = 1; @endphp
                                                            @foreach($transactions->where('cashbook_currency_id','!=', $defaultCurrency->id) as $item=>$fx)
                                                                <tr role="row" class="odd bg-secondary text-white ">
                                                                    <td class="text-left">{{ $index++ }}</td>
                                                                    <td class="text-left">{{ date('d M, Y h:ia', strtotime($fx->cashbook_transaction_date)) }}</td>
                                                                    <td class="text-left">{{ $fx->getAccount->cba_name ?? '' }}
                                                                    <td class="text-left">{{ $fx->getCategory->tc_name ?? '' }}
                                                                    </td>
                                                                    <td class="text-left" style="text-align: right">{{$fx->getCurrency->code ?? '' }} - {{$fx->getCurrency->symbol ?? '' }} {{ number_format($fx->cashbook_debit,2) }}</td>
                                                                    <td class="text-left" style="text-align: right">{{$fx->getCurrency->code ?? '' }} - {{$fx->getCurrency->symbol ?? '' }} {{ number_format($fx->cashbook_credit,2) }}</td>
                                                                    <td>
                                                                        <div class="btn-group">
                                                                            <i class="bx bx-dots-vertical dropdown-toggle text-warning" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                                                            <div class="dropdown-menu">
                                                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-target="#cashbookModal_{{$fx->cashbook_id}}" data-bs-toggle="modal"> <i class="bx bxs-book-open text-info"></i> View</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal right fade" id="cashbookModal_{{$fx->cashbook_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" style="width: 900px;">
                                                                            <div class="modal-dialog modal-lg w-100" role="document">
                                                                                <div class="modal-content" id="printArea">
                                                                                    <div class="modal-header" >
                                                                                        <h6 class="modal-title text-uppercase" style="text-align: center;" id="myModalLabel2">Report Details</h6>
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
                                                                                                            <div class="col-sm-3 mt-3">
                                                                                                                <address>
                                                                                                                    <strong>Account:</strong><br>
                                                                                                                    {{$fx->getAccount->cba_name ?? '' }}
                                                                                                                </address>
                                                                                                            </div>
                                                                                                            <div class="col-sm-3 mt-3">
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
                                                                                                            <div class="col-sm-3 mt-3 text-sm-end">
                                                                                                                <address>
                                                                                                                    <strong>Transaction Date:</strong><br>
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

                                                        </table>
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
