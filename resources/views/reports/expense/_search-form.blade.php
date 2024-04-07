<div class="col-md-6 col-lg-6 offset-lg-3 offset-md-3">
    <div class="card">
        <div class="card-body">
            <div class="modal-header">
                <h6 class="text-uppercase modal-title"> Date Range</h6>
            </div>
            <form action="{{ route('generate-cashbook-report') }}" method="get">
                @csrf
                <div class="row mt-4">
                    <div class="col-md-12 col-lg-12 mb-3">
                        <div class="form-group">
                            <label for="">Account <sup class="text-danger">*</sup></label>
                            <select name="account" id="" class="form-control">
                                <option selected disabled>-- Select account --</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->cba_id  ?? '' }}">{{ $account->cba_name ?? ''  }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">From</label>
                            <input type="date" value="{{ $from }}" name="from" class="form-control" placeholder="From">
                            <input type="hidden" name="type" value="expense">
                            @error('from') <i class="text-danger">{{$message}}</i> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">To</label>
                            <input type="date" value="{{ $to }}" name="to" class="form-control" placeholder="To">
                            @error('to') <i class="text-danger">{{$message}}</i> @enderror
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12 d-flex justify-content-center mt-4">
                        <button class="btn btn-primary" type="submit">Submit <i class="bx bxs-right-arrow"></i> </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
