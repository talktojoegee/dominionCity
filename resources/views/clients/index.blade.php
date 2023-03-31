@extends('layouts.master-layout')
@section('current-page')
    Clients
@endsection
@section('extra-styles')
    <link rel="stylesheet" href="/css/nprogress.css">
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#client" class="btn btn-primary  mb-3">Add New Client <i class="bx bxs-user"></i> </a>
                    </div>
                    <div class="card-body">

                        <h4 class="card-title">Clients</h4>
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
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Active</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Archived</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Client Group</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="home1" role="tabpanel">
                               <div class="row">
                                   <div class="col-md-12 col-lx-12">
                                       <div class="table-responsive mt-3">
                                           <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                               <thead>
                                               <tr>
                                                   <th class="">#</th>
                                                   <th class="wd-15p">Name</th>
                                                   <th class="wd-15p">Cellphone</th>
                                                   <th class="wd-15p">Email</th>
                                                   <th class="wd-15p">Group</th>
                                                   <th class="wd-15p">Action</th>
                                               </tr>
                                               </thead>
                                               <tbody>
                                               @php $index = 1; @endphp
                                               @foreach($clients->where('status',1) as $client)
                                                   <tr>
                                                       <td>{{$index++}}</td>
                                                       <td>{{$client->first_name ?? '' }} {{$client->last_name ?? '' }}</td>
                                                       <td>{{$client->mobile_no ?? '' }} </td>
                                                       <td>{{$client->email ?? '' }} </td>
                                                       <td><span class="badge rounded-pill bg-success float-end" key="t-new">{{$client->getClientGroup->group_name ?? '' }}</span> </td>
                                                       <td>
                                                           <div class="btn-group">
                                                               <i class="bx bx-dots-vertical dropdown-toggle text-warning" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                                               <div class="dropdown-menu">
                                                                   <a class="dropdown-item" href="{{route('view-client-profile', $client->slug)}}"> <i class="bx bxs-user"></i> View Profile</a>
                                                                   <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#archiveClientModal_{{$client->id}}"> <i class="bx bx-archive"></i> Archive</a>
                                                               </div>
                                                           </div>

                                                           <div id="archiveClientModal_{{$client->id}}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                                               <div class="modal-dialog" role="document">
                                                                   <div class="modal-content">
                                                                       <div class="card-header bg-custom">
                                                                           <h5 class="modal-title text-white" id="exampleModalLabel">Archive Client?</h5>
                                                                       </div>
                                                                       <form action="{{route('archive-unarchive-client')}}" method="post">
                                                                           @csrf
                                                                           <div class="modal-body">
                                                                               <div class="row">
                                                                                   <div class="col-md-12">
                                                                                       <div class="form-group">
                                                                                           <label for="">Are you sure you want to archive <strong>{{$client->first_name ?? '' }} {{$client->last_name ?? '' }}</strong>?</label>
                                                                                       </div>
                                                                                   </div>
                                                                                   <input type="hidden" name="clientId" value="{{$client->id}}" >
                                                                                   <input type="hidden" name="status" value="2" >
                                                                               </div>
                                                                           </div>
                                                                           <div class="modal-footer">
                                                                               <div class="btn-group">
                                                                                   <button data-bs-dismiss="modal" type="button" class="btn btn-secondary btn-mini"><i class="bx bx-block mr-2"></i>No, cancel</button>
                                                                                   <button type="submit" class="btn btn-custom btn-mini"><i class="bx bx-check mr-2"></i>Yes, archive</button>
                                                                               </div>
                                                                           </div>
                                                                       </form>
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
                            <div class="tab-pane" id="profile1" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12 col-lx-12">
                                        <div class="table-responsive mt-3">
                                            <table  class="table table-bordered dt-responsive  nowrap w-100">
                                                <thead>
                                                <tr>
                                                    <th class="">#</th>
                                                    <th class="wd-15p">Name</th>
                                                    <th class="wd-15p">Cellphone</th>
                                                    <th class="wd-15p">Email</th>
                                                    <th class="wd-15p">Group</th>
                                                    <th class="wd-15p">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php $index = 1; @endphp
                                                @foreach($clients->where('status',2) as $client)
                                                    <tr>
                                                        <td>{{$index++}}</td>
                                                        <td>{{$client->first_name ?? '' }} {{$client->last_name ?? '' }}</td>
                                                        <td>{{$client->mobile_no ?? '' }} </td>
                                                        <td>{{$client->email ?? '' }} </td>
                                                        <td><span class="badge rounded-pill bg-success float-end" key="t-new">{{$client->getClientGroup->group_name ?? '' }}</span> </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <i class="bx bx-dots-vertical dropdown-toggle text-warning" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item" href="{{route('view-client-profile', $client->slug)}}"> <i class="bx bxs-user"></i> View Profile</a>
                                                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-target="#unarchiveClientModal_{{$client->id}}" data-bs-toggle="modal"> <i class="bx bx-archive"></i> Archive</a>
                                                                </div>
                                                            </div>
                                                            <div id="unarchiveClientModal_{{$client->id}}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="card-header bg-custom">
                                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Un-archive Client?</h5>
                                                                        </div>
                                                                        <form action="{{route('archive-unarchive-client')}}" method="post">
                                                                            @csrf
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label for="">Are you sure you want to un-archive <strong>{{$client->first_name ?? '' }} {{$client->last_name ?? '' }}</strong>?</label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <input type="hidden" name="clientId" value="{{$client->id}}" >
                                                                                    <input type="hidden" name="status" value="1" >
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <div class="btn-group">
                                                                                    <button data-bs-dismiss="modal" type="button" class="btn btn-secondary btn-mini"><i class="bx bx-block mr-2"></i>No, cancel</button>
                                                                                    <button type="submit" class="btn btn-custom btn-mini"><i class="bx bx-check mr-2"></i>Yes, un-archive</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
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
                            <div class="tab-pane" id="messages1" role="tabpanel">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="card-title">Add New Client Group</div>
                                                <div class="card-title-desc">Groups can be used to organize your clients and to distribute forms, documents, and programs.</div>
                                                <form action="{{route('client-group')}}" method="post" autocomplete="off">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="">Client Group Name</label>
                                                        <input type="text" name="groupName" placeholder="Ex: Nutrition" class="form-control">
                                                        @error('groupName') <i class="text-danger">{{$message}}</i>@enderror
                                                    </div>
                                                    <div class="form-group d-flex justify-content-center mt-3">
                                                        <button type="submit" class="btn btn-primary">Create <i class="bx bx-right-arrow"></i> </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Client Groups</h4>
                                                <p class="card-title-desc">A list of your registered client groups</p>

                                                <div class="table-responsive">
                                                    <table class="table mb-0">

                                                        <thead class="table-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Group Name</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @php $serial = 1; @endphp
                                                        @foreach($clientGroups as $group)
                                                            <tr>
                                                                <th scope="row">{{$serial++}}</th>
                                                                <td>{{$group->group_name ?? '' }}</td>
                                                                <td>
                                                                    <a href="javascript:void(0);" data-bs-target="#editGroup_{{$group->id}}" data-bs-toggle="modal"> <i class=" bx bx-pencil text-warning"></i> </a>
                                                                    <div class="modal fade" id="editGroup_{{$group->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header" >
                                                                                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    <h4 class="modal-title" id="myModalLabel2">Edit Client Group</h4>
                                                                                </div>

                                                                                <div class="modal-body">
                                                                                    <form action="{{route('edit-client-group')}}" method="post" autocomplete="off">
                                                                                        @csrf
                                                                                        <div class="form-group">
                                                                                            <label for="">Client Group Name</label>
                                                                                            <input type="text" name="groupName" value="{{$group->group_name ?? '' }}" placeholder="Ex: Nutrition" class="form-control">
                                                                                            @error('groupName') <i class="text-danger">{{$message}}</i>@enderror
                                                                                            <input type="hidden" name="groupId" value="{{$group->id}}">
                                                                                        </div>
                                                                                        <div class="form-group d-flex justify-content-center mt-3">
                                                                                            <button type="submit" class="btn btn-primary">Save changes <i class="bx bx-right-arrow"></i> </button>
                                                                                        </div>
                                                                                    </form>

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
                </div>
            </div>
        </div>
    </div>

    <div class="modal right fade" id="client" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel2">Add New Client</h4>
                </div>

                <div class="modal-body">
                    <form autocomplete="off" action="{{route('add-client')}}" method="post">
                        @csrf
                        <div class="form-group mt-1">
                            <label for="">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="firstName" placeholder="First Name" class="form-control">
                            @error('firstName') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="lastName" placeholder="Last Name" class="form-control">
                            @error('lastName') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Mobile Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="mobileNo" placeholder="Mobile Phone Number" class="form-control">
                            @error('mobileNo') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Client Group</label>
                            <select name="clientGroup" id="" class="form-control">
                                @foreach($clientGroups as $cg)
                                    <option value="{{$cg->id}}">{{$cg->group_name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" placeholder="Email Address" class="form-control">
                            @error('email') <i class="text-danger">{{$message}}</i>@enderror
                        </div>
                        <div class="form-group d-flex justify-content-center mt-3">
                            <div class="btn-group">
                                <button id="creditChangesBtn" class="btn btn-primary  waves-effect waves-light">Add Client <i class="bx bx-plus"></i> </button>
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
@endsection
