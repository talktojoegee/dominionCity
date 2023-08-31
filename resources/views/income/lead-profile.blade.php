@extends('layouts.master-layout')
@section('current-page')
    Lead Profile
@endsection
@section('extra-styles')
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
            @include('income.partial._top-navigation')
        </div>
        <div class="row">
            <div class="col-xl-4">
                <div class="card overflow-hidden">
                    <div class="bg-primary bg-soft">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">Lead Details</h5>
                                    <p>Explore lead profile</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="/assets/images/profile-img.png" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="avatar-md profile-user-wid mb-4 align-content-center" style="width: 120px; height: 120px;" >
                                    <img style="width: 120px; height: 120px;" src="{{url('storage/avatars/avatar.png')}}" alt="" class="img-thumbnail rounded-circle">
                                </div>
                                <h5 class="font-size-15">{{$client->first_name ?? '' }} {{$client->last_name ?? '' }}</h5>
                            </div>
                            <div class="col-md-12 col-sm-12" style="display: none;">
                                <div class="btn-group">
                                    <button class="btn btn-success btn-sm"> Convert to client <i class="bx bxs-check-circle"></i></button>
                                    <button class="btn btn-danger btn-sm"> Delete <i class="bx bxs-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Personal Information</h4>
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <tbody>
                                <tr>
                                    <th scope="row">Full Name :</th>
                                    <td>{{$client->first_name ?? '' }} {{$client->last_name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Mobile :</th>
                                    <td>{{$client->phone ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">E-mail :</th>
                                    <td>{{$client->email ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Address :</th>
                                    <td>{{$client->street ?? '' }}, {{$client->city ?? '' }} {{$client->state ?? '' }} {{$client->code ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Added By :</th>
                                    <td>{{$client->getAddedBy->first_name  ?? '' }} {{$client->getAddedBy->last_name  ?? '' }}</td>
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
                                <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Activity</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Notes</span>
                                </a>
                            </li>
                            <li class="nav-item" style="display: none;">
                                <a class="nav-link" data-bs-toggle="tab" href="#documents" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Documents</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="home1" role="tabpanel">
                                <div class="mt-3" style="height: 500px; overflow-y: scroll;">
                                    <ul class="verti-timeline list-unstyled">
                                        @foreach($client->getLogs as $log)
                                            <li class="event-list">
                                                <div class="event-timeline-dot">
                                                    <i class="bx bx-right-arrow-circle"></i>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <i class="bx bx-code h4 text-primary"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div>
                                                            <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">{{$log->title ?? '' }}</a></h5>
                                                            <p>{{$log->log ?? '' }}</p>
                                                            <span class="text-primary">{{date('d M, Y h:ia', strtotime($log->created_at))}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-pane" id="profile1" role="tabpanel">
                                <form action="{{route('leave-lead-note')}}" id="leadNoteForm" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">Add Note</label>
                                        <textarea name="addNote" data-parsley-required-message="Leave a note in the box provided above" required style="resize: none;" cols="30" rows="4" placeholder="Type Note here..." class="form-control">{{old('addNote')}}</textarea>
                                        @error('addNote') <i class="text-danger">{{$message}}</i> @enderror
                                    </div>
                                    <input type="hidden" value="{{$client->id}}" name="leadId">
                                    <div class="form-group mt-1 float-end">
                                        <button type="submit" class="btn btn-info btn-lg">Add Note <i class="bx bxs-note"></i> </button>
                                    </div>
                                </form>
                                <div class="mt-5" style="height: 330px; overflow-y: scroll;">
                                    @if($client->getLeadNotes->count() > 0)
                                        @foreach($client->getLeadNotes as $note)
                                            <div class="d-flex py-3">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar-xs">
                                                        <div class="avatar-title rounded-circle bg-light text-primary">
                                                            <i class="bx bxs-user"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="font-size-14 mb-1">{{$note->getAddedBy->first_name ?? '' }} {{$note->getAddedBy->last_name ?? '' }} <small class="text-muted float-end">{{date('d M, Y h:ia', strtotime($note->created_at))}}</small></h6>
                                                    <p class="text-muted">{{$note->note ?? '' }}</p>
                                                    <div>
                                                        <a href="javascript: void(0);" data-bs-target="#deleteNote_{{$note->id}}" data-bs-toggle="modal" style="cursor:pointer;" class="text-danger"><i class="mdi mdi-trash-can"></i> Trash</a>
                                                        <a href="javascript: void(0);" data-bs-target="#editNote_{{$note->id}}" data-bs-toggle="modal"  style="cursor:pointer; margin-left: 15px;" class="text-warning ml-3"><i class="mdi mdi-lead-pencil"></i> Edit</a>
                                                    </div>
                                                    <div class="modal fade" id="editNote_{{$note->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header" >
                                                                    <h4 class="modal-title" id="myModalLabel2">Edit Note</h4>
                                                                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{route('edit-lead-note')}}" id="leadNoteForm" method="post">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <label for=""> Note</label>
                                                                            <textarea name="addNote" data-parsley-required-message="Leave a note in the box provided above" required style="resize: none;" cols="30" rows="4" placeholder="Type Note here..." class="form-control">{{$note->note ?? '' }}</textarea>
                                                                            @error('addNote') <i class="text-danger">{{$message}}</i> @enderror
                                                                        </div>
                                                                        <input type="hidden" value="{{$note->id}}" name="noteId">
                                                                        <input type="hidden" value="{{$client->id}}" name="leadId">
                                                                        <div class="form-group mt-1 float-end">
                                                                            <button type="submit" class="btn btn-info btn-lg">Save changes <i class="bx bxs-note"></i> </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="deleteNote_{{$note->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header" >
                                                                    <h4 class="modal-title" id="myModalLabel2">Delete Note</h4>
                                                                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{route('delete-lead-note')}}" id="leadNoteForm" method="post">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <p>Are you sure you want to delete this note?</p>
                                                                        </div>
                                                                        <input type="hidden" value="{{$note->id}}" name="noteId">
                                                                        <input type="hidden" value="{{$client->id}}" name="leadId">
                                                                        <div class="form-group mt-1 float-end">
                                                                            <button type="submit" class="btn btn-danger btn-lg">Delete <i class="bx bxs-trash"></i> </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <h6 class="text-center">Be the first to leave a note.</h6>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane" id="documents" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-xl-12 col-md-12 col-lg-12">
                                            <div class="card-header bg-custom text-white mb-3">Activity</div>

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

    <div class="modal right fade" id="editClientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel2">Edit Client Profile</h4>
                </div>

                <div class="modal-body">
                    <form autocomplete="off" action="{{route('edit-client-profile')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mt-1">
                            <label for="">Profile Photo</label> <br>
                            <input type="file" name="profilePhoto" class="form-control-file">
                            @error('profilePhoto') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <input type="hidden" name="clientId" value="{{$client->id}}">
                        <div class="form-group mt-3">
                            <label for="">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="firstName" placeholder="First Name" value="{{$client->first_name ?? '' }}" class="form-control">
                            @error('firstName') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="lastName" value="{{$client->last_name ?? '' }}" placeholder="Last Name" class="form-control">
                            @error('lastName') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Date of Birth </label>
                            <input type="date" value="{{date('Y-m-d', strtotime($client->birth_date))  }}" name="birthDate"  placeholder="Date of Birth" class="form-control">
                            @error('birthDate') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Mobile Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="mobileNo" value="{{$client->mobile_no ?? '' }}" placeholder="Mobile Phone Number" class="form-control">
                            @error('mobileNo') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" readonly value="{{$client->email ?? '' }}" placeholder="Email Address" class="form-control">
                            @error('email') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for=""> Address</label>
                            <textarea name="address" style="resize: none;" placeholder="Type address here..." class="form-control">{{$client->address ?? '' }}</textarea>
                            @error('address') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Current Weight </label>
                            <input type="text" name="currentWeight"  value="{{$client->current_weight ?? '' }}" placeholder="Current Weight" class="form-control">
                            @error('currentWeight') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Client Group</label>
                            <select name="clientGroup" id="" class="form-control">

                            </select>
                        </div>
                        <div class="form-group mt-1">
                            <label for=""> Quick Note</label>
                            <textarea name="quickNote" style="resize: none;" placeholder="Leave a quick note here..." class="form-control">{{$client->quick_note ?? '' }}</textarea>
                            @error('quickNote') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group d-flex justify-content-center mt-3">
                            <div class="btn-group">
                                <button class="btn btn-primary  waves-effect waves-light">Save changes <i class="bx bxs-right-arrow"></i> </button>
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
    <script src="/js/parsley.js"></script>
    <script>
        $(document).ready(function(){
            $('#leadNoteForm').parsley().on('field:validated', function() {
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
