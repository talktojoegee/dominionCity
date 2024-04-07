@extends('layouts.master-layout')
@section('current-page')
    Sales
@endsection
@section('extra-styles')
    <link rel="stylesheet" href="/css/nprogress.css">
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/parsley.css" rel="stylesheet" type="text/css" />
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
                                <p class="mb-2">Inflow</p>
                                <h5 class="mb-0 number-font">{{env('APP_CURRENCY')}}{{number_format($sales->sum('total'),2)}}</h5>
                            </div>
                            <div class="col-auto mb-0">
                                <div class="dash-icon text-orange"> <i class="bx bxs-receipt text-success fs-22"></i></div>
                            </div>
                        </div>
                        <span class="fs-12 text-success"> <strong>Overall</strong> </span>
                        <span class="text-muted fs-12 ms-0 mt-1">Sales </span>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-1">
                            <div class="col"> <p class="mb-2">Inflow</p><h5 class="mb-0 number-font">{{env('APP_CURRENCY')}}{{number_format($yesterdays->sum('total'),2)}}</h5> </div>
                            <div class="col-auto mb-0">
                                <div class="dash-icon text-secondary1"> <i class="bx bxs-receipt text-warning fs-22"></i> </div>
                            </div>
                        </div>
                        <span class="fs-12 text-warning"> <strong>Yesterday's</strong>  </span>
                        <span class="text-muted fs-12 ms-0 mt-1">Sales </span>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-1">
                            <div class="col"> <p class="mb-2">Inflow</p>
                                <h5 class="mb-0 number-font">{{env('APP_CURRENCY')}}{{number_format($todays->sum('total'),2)}}</h5>
                            </div>
                            <div class="col-auto mb-0">
                                <div class="dash-icon text-secondary"> <i class="bx bxs-receipt text-primary fs-22"></i>
                                </div>
                            </div>
                        </div>
                        <span class="fs-12 text-primary"> <strong>Today's</strong>  </span>
                        <span class="text-muted fs-12 ms-0 mt-1">Sales </span>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-1">
                            <div class="col">
                                <p class="mb-2">Inflow</p>
                                <h5 class="mb-0 number-font">{{env('APP_CURRENCY')}}{{number_format($thisWeek->sum('total'),2)}}</h5>
                            </div>
                            <div class="col-auto mb-0">
                                <div class="dash-icon text-warning"> <i class="bx bxs-receipt text-info fs-22"></i> </div>
                            </div>
                        </div>
                        <span class="fs-12 text-info"> <strong>This Week's</strong>  </span>
                        <span class="text-muted fs-12 ms-0 mt-1">Sales </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addNewProduct" class="btn btn-primary  mb-3">Create Sales <i class="bx bxs-purchase-tag-alt"></i> </a>
                    </div>
                    <div class="card-body">

                        <h4 class="card-title">Sales</h4>
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
                                            <th class="wd-15p">Client</th>
                                            <th class="wd-15p">Total</th>
                                            <th class="wd-15p">Payment Method</th>
                                            <th class="wd-15p">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $index = 1; @endphp
                                        @foreach($sales as $sale)
                                            <tr>
                                                <td>{{$index++}}</td>
                                                <td>{{date('d M, Y', strtotime($sale->transaction_date))}}</td>
                                                <td>{{$sale->getClient->first_name ?? '' }} {{$sale->getClient->last_name ?? '' }}</td>
                                                <td style="text-align: right;">{{env('APP_CURRENCY')}}{{number_format($sale->sub_total ?? 0,2)}}</td>
                                                <td>
                                                    @switch($sale->payment_method)
                                                        @case(1)
                                                        Payment Card
                                                        @break
                                                        @case(2)
                                                        Bank Account
                                                        @break
                                                        @case(3)
                                                        Manual Payment
                                                        @break
                                                        @case(4)
                                                        Cash
                                                        @break
                                                        @case(5)
                                                        Cheque
                                                        @break
                                                        @case(6)
                                                        Referral Credit
                                                        @break
                                                        @case(6)
                                                        Internet
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <i class="bx bx-dots-vertical dropdown-toggle text-warning" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-target="#viewSales_{{$sale->id}}" data-bs-toggle="modal"> <i class="bx bxs-book-open"></i> View</a>
                                                        </div>
                                                    </div>
                                                    <div class="modal right fade" id="viewSales_{{$sale->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" style="width: 900px;">
                                                        <div class="modal-dialog modal-lg w-100" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header" >
                                                                    <h4 class="modal-title" style="text-align: center;" id="myModalLabel2">Sales Details</h4>
                                                                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="card">
                                                                                <div class="card-body">
                                                                                    <div class="invoice-title">
                                                                                        <h4 class="float-end font-size-16">Transaction Ref.{{$sale->transaction_ref ?? '' }}</h4>
                                                                                        <div class="mb-4">
                                                                                            <img src="{{url('storage/'.Auth::user()->getUserOrganization->logo)}}" alt="logo" height="20">
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="row">
                                                                                        <div class="col-sm-6">
                                                                                            <address>
                                                                                                <strong>Billed To:</strong><br>
                                                                                                {{$sale->getClient->first_name ?? '' }} {{$sale->getClient->last_name ?? '' }}<br>
                                                                                                {{$sale->getClient->email ?? '' }}<br>
                                                                                                {{$sale->getClient->mobile_no ?? '' }}<br>
                                                                                                {{$sale->getClient->address ?? '' }}
                                                                                            </address>
                                                                                        </div>
                                                                                        <div class="col-sm-6 text-sm-end">
                                                                                            <address>
                                                                                                <strong>Billed From:</strong><br>
                                                                                                {{Auth::user()->getUserOrganization->organization_name ?? '' }}<br>
                                                                                                {{Auth::user()->getUserOrganization->email ?? '' }}<br>
                                                                                                {{Auth::user()->getUserOrganization->phone_no ?? '' }}<br>
                                                                                                {{Auth::user()->getUserOrganization->city ?? '' }}<br>
                                                                                                {{Auth::user()->getUserOrganization->getState->name ?? '' }}<br>
                                                                                                {{Auth::user()->getUserOrganization->address ?? '' }} {{Auth::user()->getUserOrganization->zipcode ?? '' }}
                                                                                            </address>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-sm-6 mt-3">
                                                                                            <address>
                                                                                                <strong>Payment Method:</strong><br>
                                                                                                @switch($sale->payment_method)
                                                                                                    @case(1)
                                                                                                    Payment Card
                                                                                                    @break
                                                                                                    @case(2)
                                                                                                    Bank Account
                                                                                                    @break
                                                                                                    @case(3)
                                                                                                    Manual Payment
                                                                                                    @break
                                                                                                    @case(4)
                                                                                                    Cash
                                                                                                    @break
                                                                                                    @case(5)
                                                                                                    Cheque
                                                                                                    @break
                                                                                                    @case(6)
                                                                                                    Referral Credit
                                                                                                    @break
                                                                                                    @case(6)
                                                                                                    Internet
                                                                                                    @break
                                                                                                @endswitch
                                                                                            </address>
                                                                                        </div>
                                                                                        <div class="col-sm-6 mt-3 text-sm-end">
                                                                                            <address>
                                                                                                <strong>Date:</strong><br>
                                                                                                 {{date('M d, Y', strtotime($sale->transaction_date))}}<br><br>
                                                                                            </address>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="py-2 mt-3">
                                                                                        <h3 class="font-size-15 fw-bold">Sales Breakdown</h3>
                                                                                    </div>
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-nowrap">
                                                                                            <thead>
                                                                                            <tr>
                                                                                                <th style="width: 70px;">No.</th>
                                                                                                <th>Product</th>
                                                                                                <th>Quantity</th>
                                                                                                <th class="text-end">Unit Price</th>
                                                                                                <th class="text-end">Amount</th>
                                                                                            </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                            @php $serial = 1;@endphp
                                                                                            @foreach($sale->getItems as $item)
                                                                                            <tr>
                                                                                                <td>{{$serial++}}</td>
                                                                                                <td>{{$item->getItem->product_name ?? '' }}</td>
                                                                                                <td class="text-center">{{number_format($item->quantity)}}</td>
                                                                                                <td class="text-end">{{env('APP_CURRENCY')}}{{number_format($item->unit_cost,2)}}</td>
                                                                                                <td class="text-end">{{env('APP_CURRENCY')}}{{number_format($item->unit_cost * $item->quantity,2)}}</td>
                                                                                            </tr>
                                                                                            @endforeach
                                                                                            <tr>
                                                                                                <td colspan="4" class="border-0 text-end">
                                                                                                    <strong>Subtotal</strong></td>
                                                                                                <td class="border-0 text-end">{{env('APP_CURRENCY')}}{{number_format($sale->sub_total,2)}}</td>
                                                                                            </tr>
                                                                                            @if($sale->tax_value > 0)
                                                                                            <tr>
                                                                                                <td colspan="4" class="border-0 text-end">
                                                                                                    <strong>Tax</strong></td>
                                                                                                <td class="border-0 text-end"><h4 class="m-0">{{env('APP_CURRENCY')}}{{number_format($sale->tax_value,2)}}</h4></td>
                                                                                            </tr>
                                                                                            @endif
                                                                                            @if($sale->tax_rate > 0)
                                                                                            <tr>
                                                                                                <td colspan="4" class="border-0 text-end">
                                                                                                    <strong>Tax Rate(%)</strong></td>
                                                                                                <td class="border-0 text-end"><h4 class="m-0">{{number_format($sale->tax_rate)}}</h4></td>
                                                                                            </tr>
                                                                                            @endif
                                                                                            <tr>
                                                                                                <td colspan="4" class="border-0 text-end">
                                                                                                    <strong>Total</strong></td>
                                                                                                <td class="border-0 text-end"><h4 class="m-0">{{env('APP_CURRENCY')}}{{number_format($sale->total,2)}}</h4></td>
                                                                                            </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                    <div class="d-print-none">
                                                                                        <div class="float-end">
                                                                                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i> Print</a>
                                                                                            <!--<a href="javascript: void(0);" class="btn btn-primary w-md waves-effect waves-light">Send</a> -->
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

    <div class="modal right fade" id="addNewProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" style="width: 900px;">
        <div class="modal-dialog modal-lg w-100" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <h4 class="modal-title" style="text-align: center;" id="myModalLabel2">Create Sale</h4>
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form autocomplete="off" action="{{route('create-sales')}}" id="addProductForm" data-parsley-validate="" method="post" enctype="multipart/form-data">
                        @csrf
                       <div class="row">
                           <div class="form-group mt-1 col-md-6">
                               <label for="">Client <span class="text-danger">*</span></label>
                               <select name="client"  class="form-control">
                                   @foreach($clients as $client)
                                       <option value="{{$client->id}}">{{$client->first_name ?? '' }} {{$client->last_name ?? '' }}</option>
                                   @endforeach
                               </select>
                               @error('client') <i class="text-danger">{{$message}}</i>@enderror
                           </div>
                           <div class="form-group mt-1 col-md-6">
                               <label for=""> Date<span class="text-danger">*</span></label>
                               <input type="date" value="{{date('Y-m-d', strtotime(now()))}}" name="date" class="form-control">
                               @error('date') <i class="text-danger">{{$message}}</i>@enderror
                           </div>
                       </div>
                        <div class="row">
                            <div class="form-group mt-1 col-md-6">
                                <label for="">Payment Method <span class="text-danger">*</span></label>
                                <select name="paymentMethod"  class="form-control">
                                    <option value="1">Payment Card</option>
                                    <option value="2">Bank Account</option>
                                    <option value="3">Manual Payment</option>
                                    <option value="4">Cash</option>
                                    <option value="5">Cheque</option>
                                    <option value="6">Referral Credit</option>
                                    <option value="7">Internet</option>
                                </select>
                                @error('paymentMethod') <i class="text-danger">{{$message}}</i>@enderror
                            </div>
                            <div class="form-group mt-1 col-md-6">
                                <label for=""> Transaction Reference</label>
                                <input type="text" placeholder="Transaction Reference" name="transactionReference" class="form-control">
                                @error('transactionReference') <i class="text-danger">{{$message}}</i>@enderror
                            </div>
                        </div>
                        <div class="card-alert alert alert-success mb-0 mt-4">
                            Product(s)
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table card-table table-vcenter text-nowrap mb-0 invoice-detail-table">
                                        <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="products">
                                        <tr class="item">
                                            <td >
                                                <select name="itemName[]"  class="form-control select-product select2-show-search" >
                                                    <option selected>--Select item--</option>
                                                    @foreach($products as $item)
                                                        <option value="{{$item->id}}">{{$item->product_name ?? '' }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="quantity[]" placeholder="Quantity" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" name="unitCost[]" step="0.01" placeholder="Amount" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="total[]" class="form-control total_amount" readonly>
                                            </td>
                                            <td>
                                                <i class="bx bxs-trash text-danger remove-line" style="cursor: pointer;"></i>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12 col-sm-12 col-lg-12">
                                    <button class="btn btn-sm btn-primary add-line" type="button"> <i class="bx bxs-plus-circle mr-2"></i> Add Line</button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12 col-sm-12 col-lg-12 d-flex justify-content-end">
                                    <h4 class="text-danger">Total:{{env('APP_CURRENCY')}} <span id="grand_total" style="color: #242E52;">0.00</span></h4>
                                </div>
                            </div>

                        </div>
                        <div class="form-group d-flex justify-content-center mt-3">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary  waves-effect waves-light">Save Product <i class="bx bxs-right-arrow"></i> </button>
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
    <!-- Datatable init js -->
    <script src="/assets/js/pages/datatables.init.js"></script>
    <script src="/js/parsley.js"></script>
    <script>
        $(document).ready(function(){
            $('#trackingWrapper').hide();
            $('.trackingWrapper').hide();
            $('#trackInventoryToggler').on('change',function(){
                if ($("#trackInventoryToggler").is(':checked')){
                    $('#trackingWrapper').show();
                } else {
                    $('#trackingWrapper').hide();
                }
            });
            $('.trackInventoryToggler').on('change',function(){
                if ($(".trackInventoryToggler").is(':checked')){
                    $('.trackingWrapper').show();
                } else {
                    $('.trackingWrapper').hide();
                }
            });
            $('#addProductForm').parsley().on('field:validated', function() {
                var ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            })
                .on('form:submit', function() {
                    return true;
                });
        });
    </script>
    <script>
        $(document).ready(function(){
            $('.contact-wrapper').hide();
            var grand_total = 0;
            $('.invoice-detail-table').on('mouseup keyup', 'input[type=number]', ()=> calculateTotals());

            $('#contact_type').on('change', function(e){
                var selection = $(this).val();
                if(selection == 1){
                    $("#addNewContactModal").modal('show');
                    $('.contact-wrapper').hide();
                }else{
                    $('#addNewContactModal').modal('hide');
                    $('.contact-wrapper').show();
                }
            });

            $(document).on('click', '.add-line', function(e){
                e.preventDefault();
                var new_selection = $('.item').first().clone();
                $('#products').append(new_selection);

                $(".select-product").select2({
                    placeholder: "Select product or service"
                });
                $(".select-product").select2({ width: '100%' });
                $(".select-product").last().next().next().remove();
                //calculateTotals();
            });

            $(document).on('click', '.remove-line', function(e){
                e.preventDefault();
                $(this).closest('tr').remove();
                calculateTotals();
            });

        });

        function calculateTotals(){
            const subTotals = $('.item').map((idx, val)=> calculateSubTotal(val)).get();
            const total = subTotals.reduce((a, v)=> a + Number(v), 0);
            grand_total = total;
            $('#grand_total').text(grand_total.toLocaleString());
        }
        function calculateSubTotal(row){
            const $row = $(row);
            const inputs = $row.find('input');
            const subtotal = inputs[0].value * inputs[1].value;
            $row.find('td:nth-last-child(2) input[type=text]').val(formatter.format(subtotal));
            return subtotal;
        }
        function setTotal(){
            var sum = 0;
            $(".payment").each(function(){
                sum += +$(this).val().replace(/,/g, '');
                $(".total").text(sum.toLocaleString());
            });
        }
        var formatter = new Intl.NumberFormat('en-US');
    </script>
@endsection
