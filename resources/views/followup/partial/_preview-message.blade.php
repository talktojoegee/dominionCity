<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="card-order">
                    <h6 class="mb-2"># of Contacts</h6>
                    <h2 class="text-right ">
                        <i class="mdi mdi-account-multiple icon-size float-left text-primary text-primary-shadow"></i><span>{{number_format($persons)}}</span></h2>
                </div>
            </div>
        </div>
    </div><!-- COL END -->
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card ">
            <div class="card-body">
                <div class="card-widget">
                    <h6 class="mb-2"># of Pages</h6>
                    <h2 class="text-right"><i class="ti-book icon-size float-left text-success text-success-shadow"></i><span>{{number_format($pages)}}</span></h2>
                </div>
            </div>
        </div>
    </div><!-- COL END -->
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="card-widget">
                    <h6 class="mb-2">Cost</h6>
                    <h2 class="text-right">
                        <i class="icon-size ti-wallet   float-left text-warning text-warning-shadow"></i><span>{{'₦'.number_format($cost,2)}}</span></h2>
                </div>
            </div>
        </div>
    </div><!-- COL END -->
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card ">
            <div class="card-body">
                <div class="card-widget">
                    <h6 class="mb-2">Balance</h6>
                    <h2 class="text-right">
                        <i class="ti-check icon-size float-left text-danger text-danger-shadow"></i><span>{{ '₦'.number_format($transactions->sum('credit') - $transactions->sum('debit'),2) }}</span></h2>
                </div>
            </div>
        </div>
    </div><!-- COL END -->
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="">
                @if(session()->has('success'))
                    <div class="alert alert-success mb-4">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <strong>Great!</strong>
                        <hr class="message-inner-separator">
                        <p>{!! session()->get('success') !!}</p>
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-warning mb-4">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <strong>Whoops!</strong>
                        <hr class="message-inner-separator">
                        <p>{!! session()->get('error') !!}</p>
                    </div>
                @endif
                @if(($transactions->sum('credit') - $transactions->sum('debit')) < $cost)
                    <div class="alert alert-warning mb-4">
                        <strong>Whoops!</strong>
                        <hr class="message-inner-separator">
                        <p>Insufficient balance to perform this transaction. Quickly <strong><a href="{{route('top-up')}}" target="_blank">Top-up</a></strong>.
                            You need an additional <strong>{{'₦'.number_format($cost - Auth::user()->getUserAccount->sum('credit') - Auth::user()->getUserAccount->sum('debit'),2)}}</strong> to do this.</p>
                    </div>
                @endif
                <div class="card-body">
                    <form action="{{route('send-text-message')}}" method="post">
                        @csrf
                        <div class="card">
                            <div class="modal-header">
                                Review SMS</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Sender ID</label>
                                        <input type="text" class="form-control" value="{{ $senderId ?? ''  }}" readonly name="senderId" placeholder="Sender ID">
                                        @error('sender_id') <i class="text-danger">{{$message}}</i>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Phone Numbers</label>
                                        <textarea name="phone_numbers" cols="30" readonly rows="5"
                                                  class="form-control">{{$phone_numbers}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Message</label>
                                        <textarea name="message" cols="30" readonly rows="5"
                                                  class="form-control">{{$message ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-right d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
                            @if( (Auth::user()->getUserAccount->sum('credit') - Auth::user()->getUserAccount->sum('debit')) < $cost )
                                <a href="{{route('top-up')}}" target="_blank" class=" ml-3 btn-primary text-center">Top-up <i class="bx bxs-bank"></i> </a>
                            @else
                                <button type="submit" class=" btn btn-primary ">Send Message <i class="bx bxs-right-arrow"></i> </button>
                                <input type="hidden" name="message" value="{{$message}}">
                                <input type="hidden" name="cost" value="{{$cost}}">
                                <input type="hidden" name="pages" value="{{$pages}}">
                                <input type="hidden" name="persons" value="{{$persons}}">
                                <input type="hidden" name="thirdParty" value="1">
                                <input type="hidden" name="client" value="{{$client}}">
                                <input type="hidden" name="phone_numbers" value="{{$phone_numbers}}">
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
