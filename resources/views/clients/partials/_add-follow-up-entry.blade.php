<div class="modal right fade" id="addMedication" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" >
                <h6 class="modal-title text-uppercase" id="myModalLabel2">New Follow-up Entry</h6>
                <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form autocomplete="off" data-parsley-validate="" id="addMedicationForm" action="{{route('add-medication')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="clientId" value="{{$client->id}}">
                    <div class="form-group mt-3">
                        <label for="">Subject <span class="text-danger">*</span></label>
                        <input type="text" name="drugName" required data-parsley-required-message="Enter drug name" placeholder="Subject" value="{{old('drugName') }}" class="form-control">
                        @error('drugName') <i class="text-danger">{{$message}}</i>@enderror
                    </div>
                    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected mt-3">
                            <span class="input-group-btn input-group-prepend">
                                <button class="btn btn-primary bootstrap-touchspin-down" type="button"> Date</button>
                            </span>
                        <input data-toggle="touchspin" required data-parsley-required-message="When should this person start this medication?" type="date" value="{{date('Y-m-d')}}" name="startDate" class="form-control">
                        @error('startDate') <i class="text-danger">{{$message}}</i>@enderror &nbsp;
                    </div>
                    <div class="form-group mt-4">
                        <label for="">Details <span class="text-danger">*</span> </label>
                        <textarea name="prescription" required data-parsley-required-message="Enter prescription in the box provided" placeholder="Type details here..." id="description" style="resize: none;" class="form-control">{{old('prescription')}}</textarea>
                        @error('prescription') <i class="text-danger">{{$message}}</i>@enderror
                    </div>
                    <div class="form-group d-flex justify-content-center mt-3">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary  waves-effect waves-light">Submit <i class="bx bxs-right-arrow"></i> </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
