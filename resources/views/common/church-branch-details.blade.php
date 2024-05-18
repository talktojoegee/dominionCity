@extends('layouts.master-layout')
@section('current-page')
    Church Branch Details
@endsection
@section('extra-styles')
    <link href="{{asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 mt-4">
                <div class="d-flex justify-content-between modal-header">
                    <div class="h6 text-left pl-5 text-uppercase text-primary"> {{$branch->cb_name ?? '' }}</div>
                    <a href="{{route('church-branches')}}" class="btn btn-primary mr-3" > <i class="bx bx-food-menu"></i>  Manage Church Branches</a>
                </div>

                <div class="col-xl-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Home</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Members</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#settings1" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                        <span class="d-none d-sm-block">Settings</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="home1" role="tabpanel">
                                    @if(!empty($branch->getLeadPastor) && !empty($branch->getAssistantPastor))
                                        <div class="row">
                                        <div class="col-sm-6 col-md-6">
                                            <div class="card">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-md-4">
                                                        <img class="card-img img-fluid" src="{{url('storage/'.$branch->getLeadPastor->image)}}" alt="{{$branch->getLeadPastor->first_name ?? '-'}}">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="card-body">
                                                            <blockquote class="blockquote font-size-14 mb-0">
                                                                <p>{{$branch->getLeadPastor->title ?? '-'}} {{$branch->getLeadPastor->first_name ?? '-'}} {{$branch->getLeadPastor->last_name ?? '-'}}</p>
                                                                <footer class="blockquote-footer mt-0 font-size-12">
                                                                     <cite title="Source Title">Lead Pastor</cite>
                                                                </footer>
                                                            </blockquote>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <div class="card">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-md-4">
                                                        <img class="card-img img-fluid" src="{{url('storage/'.$branch->getAssistantPastor->image)}}" alt="{{$branch->getAssistantPastor->first_name ?? '-'}}">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="card-body">
                                                            <blockquote class="blockquote font-size-14 mb-0">
                                                                <p>{{$branch->getAssistantPastor->title ?? '-'}} {{$branch->getAssistantPastor->first_name ?? '-'}} {{$branch->getAssistantPastor->last_name ?? '-'}}</p>
                                                                <footer class="blockquote-footer mt-0 font-size-12">
                                                                    <cite title="Source Title">Assistant</cite>
                                                                </footer>
                                                            </blockquote>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="text-center mt-3 mb-3">No lead pastor or assistant assigned to this branch.</p>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row mt-4">
                                        <div class="col-md-12 col-lx-12">
                                            <h5 class="text-uppercase">{{ $branch->cb_name ?? '' }} Assignment log</h5>
                                            <div class="table-responsive mt-3">
                                                <table id="" class="table table-bordered dt-responsive  nowrap w-100">
                                                    <thead>
                                                    <tr>
                                                        <th class="">#</th>
                                                        <th class="wd-15p">Date</th>
                                                        <th class="wd-15p">Name</th>
                                                        <th class="wd-15p">Position</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($branch->getChurchAssignmentLog as $key => $log)
                                                        <tr>
                                                            <td>{{ $key+1 }}</td>
                                                            <td>{{ date('d M, Y', strtotime($log->created_at)) }}</td>
                                                            <td>{{ $log->getUser->title ?? ''  }} {{ $log->getUser->first_name ?? ''  }} {{ $log->getUser->last_name ?? ''  }}</td>
                                                            <td>{{ $log->cbl_title ?? ''  }}</td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="profile1" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12 col-lx-12">
                                            <div class="table-responsive mt-3">
                                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                                    <thead>
                                                    <tr>
                                                        <th class="">#</th>
                                                        <th class="wd-15p">Name</th>
                                                        <th class="wd-15p">Mobile No.</th>
                                                        <th class="wd-15p">Type</th>
                                                        <th class="wd-15p">Email</th>
                                                        <th class="wd-15p">Country</th>
                                                        <th class="wd-5p">Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php $index = 1; @endphp
                                                    @foreach($branch->getBranchMembers as $user)
                                                        <tr>
                                                            <td>{{$index++}}</td>
                                                            <td>
                                                                <img src="{{url('storage/'.$user->image)}}" style="width: 24px; height: 24px;" alt="{{$user->first_name ?? '' }} {{$user->last_name ?? '' }}" class="rounded-circle avatar-sm">
                                                                <a href="{{route('user-profile', $user->slug)}}">{{$user->first_name ?? '' }} {{$user->last_name ?? '' }}</a> </td>
                                                            <td>{{$user->cellphone_no ?? '' }} </td>
                                                            <td>{!! $user->pastor == 1 ? "<span class='badge rounded-pill bg-success'>Pastor</span>" : "<span class='badge rounded-pill bg-secondary'>User</span>" !!}</td>
                                                            <td>{{$user->email ?? '' }} </td>
                                                            <td>{{$user->getUserCountry->name ?? '' }}</td>
                                                            <td>
                                                                {!! $user->status == 1 ? "<i class='bx bxs-check-circle text-success'></i>" : "<i class='bx bxs-x-circle text-danger'></i>" !!}
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="settings1" role="tabpanel">
                                    <div class="col-md-4 offset-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="modal-header text-uppercase mb-3">Branch Head Assignment</div>
                                                <form action="">
                                                    @csrf
                                                    <div class="form-group mb-3">
                                                        <label for="">Branch <sup class="text-danger">*</sup>  </label>
                                                        <br>
                                                        <select name="branch" id="branch" class="form-control select2 col-md-12">
                                                            <option disabled selected>--Select branch--</option>
                                                            @foreach($branches as $branch)
                                                                <option value="{{$branch->cb_id}}">{{ $branch->cb_name ?? '' }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="">Person <sup class="text-danger">*</sup>  </label>
                                                        <br>
                                                        <select name="person" id="person" class="form-control select2 col-md-12">
                                                            <option disabled selected>--Select person--</option>
                                                            @foreach($users as $user)
                                                                <option value="{{$user->id}}">{{ $user->title ?? '' }} {{ $user->first_name ?? '' }} {{ $user->last_name ?? '' }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="">Position <sup class="text-danger">*</sup>  </label>
                                                        <br>
                                                        <select name="position" id="position" class="form-control select2 col-md-12">
                                                            <option disabled selected>--Select position--</option>
                                                            <option value="1">Lead Pastor</option>
                                                            <option value="2">Assistant Pastor</option>
                                                        </select>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group  d-flex justify-content-center">
                                                        <button class="btn btn-primary btn-lg">Submit</button>
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

    <script src="/assets/libs/select2/js/select2.min.js"></script>
    <script src="/assets/js/pages/form-advanced.init.js"></script>
@endsection
