@extends('layouts.master-layout')
@section('current-page')
    Top up
@endsection
@section('extra-styles')

@endsection
@section('breadcrumb-action-btn')

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
        <div class="col-md-6 ">
            <div class="card bg-primary text-white text-center p-3">
                <div class="card-body">
                    <blockquote class="blockquote font-size-14 mb-0">
                        <h2 class="text-white"><sup>₦</sup> {{ number_format((Auth::user()->getUserAccount->sum('credit') - Auth::user()->getUserAccount->sum('debit')), 2)  }}</h2>
                        <p>Current Balance</p>
                        <footer class="blockquote-footer mt-0 font-size-12 text-white">
                            <a href="{{route('top-up-transactions')}}" class="text-white">View Transactions</a>
                        </footer>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="modal-header mb-4">
                    <div class="modal-title text-uppercase">Top-up</div>
                </div>
                <div class="card-body">
                    <form action="{{route('top-up')}}" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="">Account <sup class="text-danger">*</sup> </label>
                                    <select name="account" id="account" class="form-control">
                                        <option disabled selected>--Select account--</option>
                                        @foreach($accounts as $account)
                                            <option value="{{$account->cba_id}}">{{ $account->cba_name ?? ''  }}</option>
                                        @endforeach
                                    </select>
                                    @error('account') <i class="text-warning">{{ $message }}</i> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Expense Category <sup class="text-danger">*</sup> </label>
                                    <select name="expenseCategory" id="expenseCategory" class="form-control">
                                        <option disabled selected>--Select category--</option>
                                        @foreach($categories as $cat)
                                            <option value="{{$cat->tc_id}}">{{ $cat->tc_name ?? ''  }}</option>
                                        @endforeach
                                    </select>
                                    @error('expenseCategory') <i class="text-warning">{{ $message }}</i> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Amount <small>(Naira)</small></label>
                                    <input type="number" placeholder="Enter Amount (Naira)" name="amount" id="amount" value="{{old('amount')}}" class="form-control">
                                    <br> @error('amount')<i class="text-danger">{{$message}}</i>@enderror
                                    <p> <strong class="text-danger">NOTE:</strong> You will be redirected to Paystack to make a secure payment. We will not have access to your card details.</p>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" disabled placeholder="Full Name" name="fullName" id="fullName" value="{{ Auth::user()->first_name ?? '' }} {{Auth::user()->surname ?? '' }}" class="form-control">
                                    <br> @error('fullName')<i class="text-danger">{{$message}}</i>@enderror
                                </div>
                                <div class="form-group">
                                    <input type="hidden" disabled placeholder="Email" name="email" id="email" value="{{ Auth::user()->email ?? '' }} " class="form-control">
                                    <br> @error('email')<i class="text-danger">{{$message}}</i>@enderror
                                </div>
                                <hr style="margin: 0; padding: 0">
                                <div class="form-group d-flex justify-content-center mb-3 mt-2">
                                    <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light"> Make Payment <i class="bx bx-right-arrow ml-2"></i></button>
                                </div>
                                <img src="/assets/images/secured-by-paystack.png" alt="Secured Payment" class="opacity-30" width="100%">
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
