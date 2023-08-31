@extends('layouts.master-layout')
@section('current-page')
    {{$client->first_name ?? '' }}'s Follow-up Details
@endsection
@section('extra-styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/parsley.css" rel="stylesheet" type="text/css" />
@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    @if(session()->has('success'))
        <div class="row" role="alert">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-check-all me-2"></i>
                    {!! session()->get('success') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <div class="btn-group">
                <a href="{{ route('clients') }}"  class="btn btn-primary  mb-3">All Users <i class="bx bxs-group"></i> </a>
                <a href="{{ url()->previous() }}"  class="btn btn-secondary  mb-3">Go Back <i class="bx bxs-left-arrow"></i> </a>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4">
                <div class="card overflow-hidden">
                    <div class="bg-primary bg-soft">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">User Details</h5>
                                    <p>Explore user profile</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="/assets/images/profile-img.png" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="avatar-md profile-user-wid mb-4" style="width: 120px; height: 120px;" >
                                    <img style="width: 120px; height: 120px;" src="{{url('storage/'.$client->avatar)}}" alt="" class="img-thumbnail rounded-circle">
                                </div>
                                <h5 class="font-size-15">{{$client->first_name ?? '' }} {{$client->last_name ?? '' }}</h5>
                                <p class="text-muted mb-0"><span class="badge rounded-pill bg-success float-start" key="t-new">{{$client->getClientGroup->group_name ?? '' }}</span></p>
                            </div>

                            <div class="col-sm-8">
                                <div class="pt-4">

                                    <div class="row">
                                        <div class="col-6">
                                            <h5 class="font-size-15">{{number_format($client->getClientMedications->count())}}</h5>
                                            <p class="text-muted mb-0">Feedback</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Personal Information</h4>
                        <h5>Note :</h5>
                        <p class="text-muted mb-4">{{$client->quick_note ?? 'No note...' }}</p>
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <tbody>
                                <tr>
                                    <th scope="row">Full Name :</th>
                                    <td>{{$client->first_name ?? '' }} {{$client->last_name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Mobile :</th>
                                    <td>{{$client->mobile_no ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">E-mail :</th>
                                    <td>{{$client->email ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Address :</th>
                                    <td>{{$client->address ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Registered By :</th>
                                    <td>{{$client->getAddedBy->first_name  ?? '' }} {{$client->getAddedBy->last_name  ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Archived? :</th>
                                    <td>
                                        <input type="checkbox" disabled id="archivedToggler" switch="primary" {{$client->status == 2 ? 'checked' : '' }}>
                                        <label for="archivedToggler" data-on-label="Yes" data-off-label="No"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Assigned To :</th>
                                    <td>{{$client->getAssignedTo->first_name  ?? '' }} {{$client->getAssignedTo->last_name  ?? '' }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#medication" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Follow-up</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#otherMedications" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Other Follow-up Reports</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="medication" role="tabpanel">
                                <div class="btn-group">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMedication">Add New <i class="bx bxs-plus-circle"></i> </button>
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editMedication">Edit Conversation <i class="bx bxs-pencil"></i> </button>
                                </div>

                                <blockquote class="blockquote font-size-14 mb-2 mt-4">
                                    <table class="table table-striped">
                                        <tr>
                                            <td><strong>Subject:</strong></td>
                                            <td>{{$medication->drug_name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong> Date:</strong></td>
                                            <td>{{ date('d M, Y', strtotime($medication->start_date)) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Details:</strong></td>
                                            <td>{!! $medication->prescription ?? ''  !!}</td>
                                        </tr>
                                    </table>
                                    <footer class="blockquote-footer mt-0 font-size-12">
                                        {{$medication->getPrescribedBy->first_name ?? '' }} {{$medication->getPrescribedBy->last_name ?? '' }} On: <cite title="Source Title">{{date('d M, Y h:ia', strtotime($medication->created_at))}}</cite>
                                    </footer>
                                </blockquote>
                                <div class="modal-header mt-4 mb-4">
                                    <h6 class="modal-title text-uppercase">Feedbacks</h6>
                                </div>
                                <div style="height: 200px; overflow-y: scroll;">
                                    @if($medication->getClientMedicationReports->count() > 0)
                                        @foreach($medication->getClientMedicationReports as $medReport)
                                            <div class="d-flex py-3 border-top">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar-sm">
                                                        <img style="height: 48px; width: 48px;" src="{{url('storage/'.$medReport->getReportedBy->image)}}" alt="" class="img-fluid d-block rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="font-size-14 mb-1">{{$medReport->getReportedBy->first_name ?? '' }} {{$medReport->getReportedBy->last_name ?? '' }} <small class="text-muted float-end">{{date('d M, Y h:ia', strtotime($medReport->created_at)) }}</small></h5>
                                                    {!! $medReport->report ?? '' !!}
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <li class="text-center" style="list-style-type: none;">This follow-up conversation currently has no feedback.</li>
                                    @endif

                                </div>
                                <div class="mt-2">
                                    <div class="mt-4">
                                        <h5 class="font-size-16 mb-3">Leave a Feedback</h5>
                                        <form id="newMedicationReportForm" method="post" action="{{route('medication-report')}}" data-parsley-validate="">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="commentmessage-input" class="form-label">Feedback</label>
                                                <textarea style="resize: none;" required data-parsley-required-message="Type your feedback here before submitting..." class="form-control" name="report" placeholder="Your feedback..." rows="3">{{old('report')}}</textarea>
                                                @error('report') <i class="text-danger mt-2">{{$message}}</i> @enderror
                                                <input type="hidden" name="medicationId" value="{{$medication->id}}">
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary w-sm">Submit <i class="bx bxs-note"></i> </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="otherMedications" role="tabpanel">
                                <div class="table-responsive mt-3">
                                    <table id="datatable1" class="table table-bordered dt-responsive  nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th class="">#</th>
                                            <th class="wd-15p"> Date</th>
                                            <th class="wd-15p">Contacted By</th>
                                            <th class="wd-15p">Subject</th>
                                            <th class="wd-15p">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $index = 1; @endphp
                                        @foreach($client->getClientMedications->where('id', '!=', $medication->id) as $med)
                                            <tr>
                                                <td>{{$index++}}</td>
                                                <td>
                                                    {{date('d M, Y h:ia', strtotime($med->start_date))}}
                                                </td>
                                                <td>
                                                    {{$med->getPrescribedBy->first_name ?? '' }}  {{$med->getPrescribedBy->last_name ?? '' }}

                                                </td>
                                                <td>
                                                    {{$med->drug_name ?? '' }}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <i class="bx bx-dots-vertical dropdown-toggle text-warning" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{route('medication-details', $med->slug)}}"> <i class="bx bxs-book-open"></i> View Details</a>
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



    <div class="modal right fade" id="editMedication" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <h6 class="modal-title text-uppercase" id="myModalLabel2">Edit Conversation</h6>
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form autocomplete="off" data-parsley-validate="" id="addMedicationForm" action="{{route('edit-medication')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="medicationId" value="{{$medication->id}}">
                        <input type="hidden" name="clientId" value="{{$client->id}}">
                        <div class="form-group mt-3">
                            <label for="">Subject <span class="text-danger">*</span></label>
                            <input type="text" name="drugName" required data-parsley-required-message="Enter drug name" placeholder="Drug Name" value="{{$medication->drug_name ?? ''  }}" class="form-control">
                            @error('drugName') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected mt-3">
                            <span class="input-group-btn input-group-prepend">
                                <button class="btn btn-primary bootstrap-touchspin-down" type="button"> Date</button>
                            </span>
                            <input data-toggle="touchspin"  required data-parsley-required-message="When should this person start this medication?" type="date" value="{{date('Y-m-d', strtotime($medication->start_date))}}" name="startDate" class="form-control">
                            @error('startDate') <i class="text-danger">{{$message}}</i>@enderror &nbsp;
                        </div>
                        <div class="form-group mt-4">
                            <label for="">Details <span class="text-danger">*</span> </label>
                            <textarea name="prescription" required data-parsley-required-message="Enter details in the box provided" placeholder="Type details here..." id="description" style="resize: none;" class="form-control description">{{$medication->prescription ?? '' }}</textarea>
                            @error('prescription') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group d-flex justify-content-center mt-3">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary  waves-effect waves-light">Save changes <i class="bx bxs-right-arrow"></i> </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @include('clients.partials._add-follow-up-entry')
@endsection

@section('extra-scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.0/html2pdf.bundle.min.js"></script>

    <script src="/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script src="/assets/js/pages/datatables.init.js"></script>
    <script src="/js/axios.min.js"></script>
    <script src="/js/parsley.js"></script>
    <script>
        $(document).ready(function(){

            $('.description').summernote({
                height:200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ]

            });
            $('#description').summernote({
                height:200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ]

            });


            $('#newMedicationReportForm').parsley().on('field:validated', function() {
                var ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            })
                .on('form:submit', function() {
                    return true;
                });
        });
    </script>


@endsection
