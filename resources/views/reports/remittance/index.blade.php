@extends('layouts.master-layout')
@section('current-page')
    Remittance Report
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
                @include('reports.remittance._search-form')
            @else
                @include('reports.remittance._search-form')
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title"> Remittance Report</h4>
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                <span class="d-none d-sm-block">{{$defaultCurrency->name ?? '' }} ({{$defaultCurrency->symbol ?? '' }}) Transactions</span>
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
                                                </div>

                                                <div class="col-md-12 col-lg-12">
                                                    <div class="table-responsive mt-3">
                                                        <table id="complex-header" class="table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="complex-header_info" style="width: 100%; margin:0px auto;">
                                                            <thead style="position: sticky;top: 0">
                                                            <tr role="row">
                                                                <th class="sorting_asc text-left text-uppercase header" tabindex="0">S/No.</th>
                                                                <th class="sorting_asc text-left text-uppercase header" tabindex="0" >Branch</th>
                                                                <th class="sorting_asc text-left text-uppercase header" tabindex="0" >Date</th>
                                                                <th class="sorting_asc text-left text-uppercase header" tabindex="0" >Remitted By</th>
                                                                <th class="sorting_asc text-left text-uppercase header" tabindex="0" >Amount({{$defaultCurrency->symbol ?? '' }})</th>
                                                                <th class="sorting_asc text-left text-uppercase header" tabindex="0" >Remitted({{$defaultCurrency->symbol ?? '' }})</th>
                                                                <th class="sorting_asc text-left text-uppercase header" tabindex="0" >Rate</th>
                                                                <th class="sorting_asc text-left text-uppercase header" tabindex="0" >Category</th>
                                                                <th class="sorting_asc text-left text-uppercase header" tabindex="0" >Period</th>
                                                                <th class="sorting_asc text-left text-uppercase header" tabindex="0" >Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php
                                                                $a = 1;
                                                            @endphp
                                                            @foreach($transactions as $trans)
                                                                <tr role="row" class="odd  $report->type == 0 ? 'bg-secondary text-white' : '' }}">
                                                                    <td class="">{{ $a++}}</td>
                                                                    <td class="">{{$trans->getBranch->cb_name ?? '' }}</td>
                                                                    <td class="">{{ date('d M, Y', strtotime($trans->r_transaction_date)) }}</td>
                                                                    <td class="">{{$trans->getRemittedBy->first_name ?? '' }} {{$trans->getRemittedBy->last_name ?? '' }}</td>
                                                                    <td class="" style="text-align: right">{{number_format($trans->r_actual_amount,2)}}</td>
                                                                    <td class="" style="text-align: right">{{number_format($trans->r_amount,2)}}</td>
                                                                    <td class="">{{$trans->r_rate.'%' ?? 0 }}</td>
                                                                    <td class="">{{$trans->getCategory->tc_name ?? '' }}</td>
                                                                    <td class=""> {{ date('d M, Y', strtotime($trans->r_from)) }} <code>to </code>{{ date('d M, Y', strtotime($trans->r_to)) }}</td>
                                                                    <td class="">
                                                                        <div class="btn-group">
                                                                            <i class="bx bx-dots-vertical dropdown-toggle text-warning" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                                                            <div class="dropdown-menu">
                                                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-target="#remittanceModal_{{$trans->r_id}}" data-bs-toggle="modal"> <i class="bx bxs-book-open text-info"></i> View</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal right fade" id="remittanceModal_{{$trans->r_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" style="width: 900px;">
                                                                            <div class="modal-dialog modal-lg w-100" role="document">
                                                                                <div class="modal-content" id="printArea">
                                                                                    <div class="modal-header" >
                                                                                        <h6 class="modal-title text-uppercase" style="text-align: center;" id="myModalLabel2"> Details</h6>
                                                                                        <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div class="row">
                                                                                            <div class="col-lg-12">
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                        <div class="invoice-title">
                                                                                                            <h5 class="float-end font-size-16">Transaction Ref.{{$trans->r_ref_code ?? '' }}</h5>
                                                                                                            <div class="mb-4">
                                                                                                                <img src="{{url('storage/'.Auth::user()->getUserOrganization->logo)}}" alt="logo" height="20">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <hr>
                                                                                                        <div class="row">
                                                                                                            <div class="col-sm-6">
                                                                                                                <address>
                                                                                                                    <strong>Entry By:</strong><br>
                                                                                                                    {{$trans->getRemittedBy->first_name ?? '' }} {{$trans->getRemittedBy->last_name ?? '' }}<br>
                                                                                                                    {{$trans->getRemittedBy->email ?? '' }}<br>
                                                                                                                    {{$trans->getRemittedBy->mobile_no ?? '' }}<br>
                                                                                                                    {{$trans->getRemittedBy->address ?? '' }}
                                                                                                                </address>
                                                                                                            </div>
                                                                                                            <div class="col-sm-6 text-sm-end">
                                                                                                                <address>
                                                                                                                    <strong>Branch:</strong><br>
                                                                                                                    {{$trans->getBranch->cb_name ?? ''  }}<br>
                                                                                                                    {{$trans->getBranch->cb_mobile_no ?? ''  }}<br>
                                                                                                                    {{$trans->getBranch->cb_email ?? ''  }}<br>
                                                                                                                    {{$trans->getBranch->cb_address ?? ''  }}<br>
                                                                                                                </address>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="row">
                                                                                                            <div class="col-sm-3 mt-3">
                                                                                                                <address>
                                                                                                                    <strong>Category:</strong><br>
                                                                                                                    {{$trans->getCategory->tc_name ?? '' }}
                                                                                                                </address>
                                                                                                            </div>
                                                                                                            <div class="col-sm-3 mt-3 ">
                                                                                                                <address>
                                                                                                                    <strong>Transaction Date:</strong><br>
                                                                                                                    {{date('M d, Y h:ia', strtotime($trans->r_transaction_date))}}<br><br>
                                                                                                                </address>
                                                                                                            </div>
                                                                                                            <div class="col-sm-4 mt-3 ">
                                                                                                                <address>
                                                                                                                    <strong>Period:</strong><br>
                                                                                                                    {{ date('d M, Y', strtotime($trans->r_from)) }} <code>to </code>{{ date('d M, Y', strtotime($trans->r_to)) }}<br><br>
                                                                                                                </address>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="row">
                                                                                                            <div class="col-md-6 col-lg-6 p-3">
                                                                                                                <div class="mb-3">
                                                                                                                    <div class="modal-header">
                                                                                                                        <h6 class="tx-11 fw-bolder text-uppercase">Before</h6>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="mt-1">
                                                                                                                    <label class="tx-11 fw-bolder mb-0 text-uppercase">Amount</label>
                                                                                                                    <p class="text-muted">{{ $trans->getCurrency->code }} {{ $trans->getCurrency->symbol }} {{number_format($trans->r_actual_amount ?? 0,2)}}
                                                                                                                        <br>
                                                                                                                    <small>(<?php
                                                                                                                        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                                                                                                                        $f->setTextAttribute(NumberFormatter::DEFAULT_RULESET, "%spellout-numbering-verbose");
                                                                                                                        echo ucfirst($f->format($trans->r_actual_amount)).' '.strtolower($trans->getCurrency->name);
                                                                                                                        ?>)</small>
                                                                                                                    </p>
                                                                                                                </div>
                                                                                                                <div class="mt-1">
                                                                                                                    <label class="tx-11 fw-bolder mb-0 text-uppercase">Rate</label>
                                                                                                                    <p class="text-muted">{{number_format($trans->r_rate ?? 0).'%'}}
                                                                                                                    </p>
                                                                                                                </div>
                                                                                                                <div class="mt-1">
                                                                                                                    <label class="tx-11 fw-bolder mb-0 text-uppercase">Narration</label>
                                                                                                                    <p class="text-muted">{{$trans->r_narration ?? '' }}</p>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="col-md-6 col-lg-6 bg-light-grey p-3">
                                                                                                                <div class="mb-3">
                                                                                                                    <div class="modal-header">
                                                                                                                        <h6 class="tx-11 fw-bolder text-uppercase">After</h6>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="mt-1">
                                                                                                                    <label class="tx-11 fw-bolder mb-0 text-uppercase">Amount</label>
                                                                                                                    <p class="text-muted">{{ $trans->getCurrency->code }} {{ $trans->getCurrency->symbol }}{{number_format($trans->r_amount ?? 0,2)}}
                                                                                                                        <br>
                                                                                                                        <small>(<?php
                                                                                                                            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                                                                                                                            $f->setTextAttribute(NumberFormatter::DEFAULT_RULESET, "%spellout-numbering-verbose");
                                                                                                                            echo ucfirst($f->format($trans->r_amount)).' '.strtolower($trans->getCurrency->name);
                                                                                                                            ?>)</small>
                                                                                                                    </p>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="mb-3">
                                                                                                            <div class="modal-header">
                                                                                                                <h6 class="tx-11 fw-bolder text-uppercase">Transactions</h6>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="table-responsive">
                                                                                                            <table class="table table-nowrap">
                                                                                                                <thead>
                                                                                                                <tr>
                                                                                                                    <th class="">#</th>
                                                                                                                    <th class="wd-15p">Date</th>
                                                                                                                    <th class="wd-15p">Account</th>
                                                                                                                    <th class="wd-15p">Amount({{env('APP_CURRENCY')}})</th>
                                                                                                                    <th class="wd-15p">Payment Method</th>
                                                                                                                </tr>
                                                                                                                </thead>
                                                                                                                <tbody>
                                                                                                                @php $index = 1; @endphp
                                                                                                                @foreach($trans->getCashbookTransactions($trans->r_ref_code) as $sale)
                                                                                                                    <tr>
                                                                                                                        <td>{{$index++}}</td>
                                                                                                                        <td>{{date('d M, Y', strtotime($sale->cashbook_transaction_date))}}</td>
                                                                                                                        <td>{{$sale->getAccount->cba_name ?? '' }} ({{$sale->getAccount->cba_account_no ?? '' }})</td>
                                                                                                                        <td style="text-align: right;">{{number_format($sale->cashbook_credit ?? 0,2)}}</td>
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
                                                                                                                    </tr>
                                                                                                                @endforeach
                                                                                                                <tr>
                                                                                                                    <td colspan="3" style="text-align: right;"><strong>Total: </strong></td>
                                                                                                                    <td style="text-align: right;">{{number_format($trans->getCashbookTransactions($trans->r_ref_code)->sum('cashbook_credit') ?? 0,2)}}</td>
                                                                                                                </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </div>
                                                                                                        <div class="d-print-none">
                                                                                                            <div class="float-end">
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
            let element = document.getElementById('printArea');
            html2pdf(element,{
                margin:       10,
                filename:     "Remittance_PrintOut_"+".pdf",
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, logging: true, dpi: 192, letterRendering: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            });
        }
    </script>
@endsection
