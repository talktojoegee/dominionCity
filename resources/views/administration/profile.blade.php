@extends('layouts.master-layout')
@section('current-page')

@endsection
@section('extra-styles')
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="row mb-10" style="margin-bottom: 70px;">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="position-relative">
                    <div class="d-flex justify-content-between align-items-center position-absolute top-90 w-100 px-2 px-md-4 mt-n4">
                        <div>
                            <img class="wd-70 rounded-circle img-thumbnail avatar-xl" src="{{url('storage/'.$user->image)}}" alt="profile">
                            <span class="h4 ms-3 text-dark">{{$user->title ?? '' }} {{$user->first_name ?? '' }}</span> ||
                            <span class="badge badge-soft-info p-1">{{$user->getUserChurchBranch->cb_name ?? '' }}</span>
                        </div>
                        <div class="d-none d-md-block">
                            <div class="btn-group">
                                <a href="" class="btn btn-primary btn-sm btn-icon-text">
                                    <i class="bx bx-user"></i> Edit profile
                                </a>
                                <a href="" class="btn btn-danger btn-sm btn-icon-text">
                                  <i class="bx bx-x-circle"></i>  Deactivate Account
                                </a>
                                <a href="javascript:void(0);" data-bs-target="#permissionModal" data-bs-toggle="modal" class="btn btn-secondary btn-sm btn-icon-text">
                                  <i class="bx bx-lock-alt"></i>  Access Level
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row profile-body">
        <div class="d-none d-md-block col-md-4 col-xl-3 left-wrapper">
            <div class="card rounded">
                <div class="">
                    <div class="modal-header">
                        <h6 class="tx-11 fw-bolder text-uppercase">Personal Info</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-end mb-2">
                        <div class="dropdown">
                            <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal icon-lg text-muted pb-3px"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 icon-sm me-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg> <span class="">Manage Permission</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-branch icon-sm me-2"><line x1="6" y1="3" x2="6" y2="15"></line><circle cx="18" cy="6" r="3"></circle><circle cx="6" cy="18" r="3"></circle><path d="M18 9a9 9 0 0 1-9 9"></path></svg> <span class="">Change Password</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye icon-sm me-2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> <span class="">View Newsfeed</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Full Name</label>
                        <p class="text-muted">{{$user->title ?? '' }} {{$user->first_name ?? '' }} {{$user->last_name ?? '' }} {{$user->other_names ?? '' }}</p>
                    </div>
                    <div class=" mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Mobile No.</label>
                        <p class="text-muted">{{$user->cellphone_no ?? '' }}</p>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Email</label>
                        <p class="text-muted"><a href="mailto:{{$user->email ?? '#'}}">{{$user->email ?? '#'}}</a></p>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Marital Status</label>
                        <p class="text-muted">{{$user->getUserMaritalStatus->ms_name ?? '' }}</p>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Gender</label>
                        <p class="text-muted">{{$user->gender == 0 ? 'Female' : 'Male' }}</p>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Birth Date</label>
                        <p class="text-muted">{{!is_null($user->birth_date) ? date('d M', strtotime($user->birth_date)) : '' }}</p>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Nationality</label>
                        <p class="text-muted">{{$user->getUserCountry->name ?? '-'}}</p>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">State</label>
                        <p class="text-muted">{{$user->getUserState->name ?? '-'}}</p>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Occupation</label>
                        <p class="text-muted">{{$user->occupation ?? '-'}}</p>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Address</label>
                        <p class="text-muted">{{$user->address_1 ?? '' }}</p>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Branch</label>
                        <p class="text-muted">{{$user->getUserChurchBranch->cb_name ?? '' }}</p>
                    </div>
                    <div class="mt-1">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Role <span style="cursor: pointer;" id="clientAssignmentToggler"><i class="bx bxs-pencil text-warning"></i></span></label>
                        <p class="text-muted">{{$user->roles->first()->name ?? '' }}</p>
                    </div>
                    <div class="mt-1 bg-light p-4" id="clientAssignmentWrapper">
                        <form action="{{route('assign-revoke-role')}}" method="post">
                            @csrf
                            <h6 class="card-header bg-custom text-white mb-3">Assign Role</h6>
                            <div class="form-group">
                                <label for="">Role Assignment</label>
                                <select name="role" id="role" class="form-control">
                                    <option disabled selected>--Choose someone--</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}"> {{$role->name ?? '' }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="userId" value="{{$user->id}}">
                                <input type="hidden" name="action" value="1">
                            </div>
                            <div class="form-group mt-3 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary btn-sm">Save changes <i class="bx bxs-right-arrow"></i> </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-8 col-xl-9 middle-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
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
                        @if(session()->has('error'))
                            <div class="row" role="alert">
                                <div class="col-md-12">
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <i class="mdi mdi-check-all me-2"></i>

                                        {!! session()->get('error') !!}

                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @foreach($posts as $post)
                        <div class="card rounded">
                            <div class="card-header">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img class="avatar-xs rounded-circle"
                                             src="{{url('storage/'.$post->getAuthor->image ?? 'avatar.png')}}"
                                             alt="{{$post->getAuthor->first_name ?? '' }}" class="avatar-sm">
                                        <div class="ms-2">
                                            <a href="{{ route('read-timeline-post', $post->p_slug) }}">{{$post->p_title ?? '' }}</a>
                                            <p class="tx-11 text-muted">{{$post->getAuthor->title ?? '' }} {{$post->getAuthor->first_name ?? '' }} {{$post->getAuthor->last_name ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                {!! strlen(strip_tags($post->p_content)) > 150 ? substr(strip_tags($post->p_content), 0,150).'...<a href='.$post->p_slug.'>Read more</a>' : strip_tags($post->p_content) !!}
                            </div>
                        </div>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <h6 class="modal-title text-uppercase" id="myModalLabel2">Access Level</h6>
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form autocomplete="off" autcomplete="off" action="{{route('add-permission')}}" method="post" id="addBranch" data-parsley-validate="">
                        @csrf
                            <div class="accordion-item mb-2">
                                <h2 class="accordion-header" id="flush-heading_">
                                    <button class="accordion-button fw-medium " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_" aria-expanded="false" aria-controls="flush-collapse_">
                                        {{$user->roles->first()->name ?? '' }}
                                    </button>
                                </h2>
                                <div id="flush-collapse_" class="accordion-collapse collapse show" aria-labelledby="flush-heading_" data-bs-parent="#accordionFlushExample_" style="">
                                    <div class="accordion-body text-muted">
                                        <form action="">
                                            <div class="row">
                                                @if(count($user->roles) > 0)
                                                    @foreach($user->roles->first()->permissions as $p)
                                                        <div class="col-md-3 col-lg-3">
                                                            <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                                <input class="form-check-input" type="checkbox"  checked="">
                                                                <label class="form-check-label" >
                                                                    {{$p->name ?? ''}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <hr>
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
    <script>
        $(document).ready(function(){
            $('#clientAssignmentWrapper').hide();
            $("#clientAssignmentToggler").click(function(){
                $("#clientAssignmentWrapper").toggle();
            });
        });
    </script>
@endsection
