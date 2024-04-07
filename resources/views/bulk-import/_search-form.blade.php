<div class="col-md-4 col-lg-4">
    <div class="card">
        <div class="card-body">
            <p><strong class="text-danger">Note:</strong> You're advised to use this feature to upload/import bulk transactions only
                by following the <a href="">template/sample as shown here.</a> Anything other than this may result in wrong entries to the system. </p>
            <p>Kindly download the template to ensure that the file/attachment you intend to upload/import complies with it.</p>
            <p>Also, ensure that your <code>batch code</code> is unique. That is, you've not used it before on the system. This is done to avoid duplicate entries.</p>
        </div>
    </div>
</div>

<div class="col-md-6 col-lg-6 ">
    <div class="card">
        <div class="card-body">
            <div class="modal-header mb-3">
                <h6 class="text-uppercase modal-title"> Bulk Import Transactions</h6>
            </div>
            <form action="{{ route('process-bulk-import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row mt-4">
                    <div class="col-md-12 col-12 col-sm-12 mb-4">
                        <div class="form-group">
                            <label for="">Account <sup class="text-danger">*</sup></label>
                            <select name="account" id="account" class="form-control">
                                <option disabled selected>-- Select an account --</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->cba_id }}">{{ $account->cba_name ?? '' }}</option>
                                @endforeach
                            </select>
                            @error('account') <i class="text-danger">{{$message}}</i> @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="" class="form-label">Month & Year <sup class="text-danger">*</sup></label>
                            <input type="month" value="{{ old('monthYear') }}" name="monthYear" class="form-control" placeholder="Month & Year">
                            @error('monthYear') <i class="text-danger">{{$message}}</i> @enderror
                        </div>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="form-group">
                            <label for="" class="form-label">Batch Code <sup class="text-danger">*</sup></label>
                            <input type="text" value="{{ old('batchCode') }}"  name="batchCode" class="form-control" placeholder="Batch Code">
                            @error('batchCode') <i class="text-danger">{{$message}}</i> @enderror
                        </div>
                    </div>

                    <div class="col-md-12 col-12 col-sm-12 mt-4">
                        <div class="form-group">
                            <label for="">Attachment <small>(.xlsx, .xls format only)</small> <sup class="text-danger">*</sup></label> <br>
                            <input type="file" name="attachment" class="form-control-file">
                            @error('attachment') <i class="text-danger">{{$message}}</i> @enderror
                        </div>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="form-group">
                            <label for="" class="form-label">Header<sup class="text-danger">*</sup></label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="firstRowHeader">
                                <label class="form-check-label" for="remember">
                                    Check this box if the first row in your Excel document contains headers.
                                </label>
                            </div>
                            @error('firstRowHeader') <i class="text-danger">{{$message}}</i> @enderror
                        </div>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="form-group">
                            <label for="" class="form-label">Narration <small>(Optional)</small></label>
                            <textarea name="narration" placeholder="Enter your narration here..." class="form-control">{{ old('narration') }}</textarea>
                            @error('narration') <i class="text-danger">{{$message}}</i> @enderror
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
