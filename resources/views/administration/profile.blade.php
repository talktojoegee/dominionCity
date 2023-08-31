@extends('layouts.master-layout')
@section('current-page')
    Profile
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
                    <figure class="overflow-hidden mb-0 d-flex justify-content-center">
                        <img src="{{url('storage/covers/profile-cover.jpg')}}" class="rounded-top " alt="profile cover">
                    </figure>
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
        <!-- left wrapper start -->
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
        <div class="col-md-8 col-xl-6 middle-wrapper">
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
                    <div class="card rounded">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img class="avatar-xs rounded-circle" src="https://www.nobleui.com/html/template/assets/images/faces/face1.jpg" alt="">
                                    <div class="ms-2">
                                        <p>Mike Popescu</p>
                                        <p class="tx-11 text-muted">1 min ago</p>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <a type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal icon-lg pb-3px"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-meh icon-sm me-2"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="15" x2="16" y2="15"></line><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg> <span class="">Unfollow</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-corner-right-up icon-sm me-2"><polyline points="10 9 15 4 20 9"></polyline><path d="M4 20h7a4 4 0 0 0 4-4V4"></path></svg> <span class="">Go to post</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2 icon-sm me-2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg> <span class="">Share</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy icon-sm me-2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg> <span class="">Copy link</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="mb-3 tx-14">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus minima delectus nemo unde quae recusandae assumenda.</p>
                            <img class="img-fluid" src="../../../assets/images/photos/img2.jpg" alt="">
                        </div>
                        <div class="card-footer">
                            <div class="d-flex post-actions">
                                <a href="javascript:;" class="d-flex align-items-center text-muted me-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart icon-md"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                    <p class="d-none d-md-block ms-2">Like</p>
                                </a>
                                <a href="javascript:;" class="d-flex align-items-center text-muted me-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square icon-md"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                    <p class="d-none d-md-block ms-2">Comment</p>
                                </a>
                                <a href="javascript:;" class="d-flex align-items-center text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share icon-md"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg>
                                    <p class="d-none d-md-block ms-2">Share</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card rounded">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img class="img-xs rounded-circle" src="https://www.nobleui.com/html/template/assets/images/faces/face1.jpg" alt="">
                                    <div class="ms-2">
                                        <p>Mike Popescu</p>
                                        <p class="tx-11 text-muted">5 min ago</p>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <a type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal icon-lg pb-3px"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-meh icon-sm me-2"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="15" x2="16" y2="15"></line><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg> <span class="">Unfollow</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-corner-right-up icon-sm me-2"><polyline points="10 9 15 4 20 9"></polyline><path d="M4 20h7a4 4 0 0 0 4-4V4"></path></svg> <span class="">Go to post</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2 icon-sm me-2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg> <span class="">Share</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy icon-sm me-2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg> <span class="">Copy link</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="mb-3 tx-14">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            <img class="img-fluid" src="../../../assets/images/photos/img1.jpg" alt="">
                        </div>
                        <div class="card-footer">
                            <div class="d-flex post-actions">
                                <a href="javascript:;" class="d-flex align-items-center text-muted me-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart icon-md"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                    <p class="d-none d-md-block ms-2">Like</p>
                                </a>
                                <a href="javascript:;" class="d-flex align-items-center text-muted me-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square icon-md"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                    <p class="d-none d-md-block ms-2">Comment</p>
                                </a>
                                <a href="javascript:;" class="d-flex align-items-center text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share icon-md"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg>
                                    <p class="d-none d-md-block ms-2">Share</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- middle wrapper end -->
        <!-- right wrapper start -->
        <div class="d-none d-xl-block col-xl-3">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="card rounded">
                        <div class="">
                            <div class="modal-header">
                                <h6 class="tx-11 fw-bolder text-uppercase">December Birthdays</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row ms-0 me-0">
                                <a href="javascript:;" class="col-md-4 ps-1 pe-1">
                                    <figure class="mb-2">
                                        <img class="img-fluid rounded" src="https://www.nobleui.com/html/template/assets/images/faces/face1.jpg" alt="">
                                    </figure>
                                </a>
                                <a href="javascript:;" class="col-md-4 ps-1 pe-1">
                                    <figure class="mb-2">
                                        <img class="img-fluid rounded" src="https://www.nobleui.com/html/template/assets/images/faces/face2.jpg" alt="">
                                    </figure>
                                </a>
                                <a href="javascript:;" class="col-md-4 ps-1 pe-1">
                                    <figure class="mb-2">
                                        <img class="img-fluid rounded" src="https://www.nobleui.com/html/template/assets/images/faces/face3.jpg" alt="">
                                    </figure>
                                </a>
                                <a href="javascript:;" class="col-md-4 ps-1 pe-1">
                                    <figure class="mb-2">
                                        <img class="img-fluid rounded" src="https://www.nobleui.com/html/template/assets/images/faces/face4.jpg" alt="">
                                    </figure>
                                </a>
                                <a href="javascript:;" class="col-md-4 ps-1 pe-1">
                                    <figure class="mb-2">
                                        <img class="img-fluid rounded" src="https://www.nobleui.com/html/template/assets/images/faces/face5.jpg" alt="">
                                    </figure>
                                </a>
                                <a href="javascript:;" class="col-md-4 ps-1 pe-1">
                                    <figure class="mb-2">
                                        <img class="img-fluid rounded" src="https://www.nobleui.com/html/template/assets/images/faces/face6.jpg" alt="">
                                    </figure>
                                </a>
                                <a href="javascript:;" class="col-md-4 ps-1 pe-1">
                                    <figure class="mb-0">
                                        <img class="img-fluid rounded" src="https://www.nobleui.com/html/template/assets/images/faces/face7.jpg" alt="">
                                    </figure>
                                </a>
                                <a href="javascript:;" class="col-md-4 ps-1 pe-1">
                                    <figure class="mb-0">
                                        <img class="img-fluid rounded" src="https://www.nobleui.com/html/template/assets/images/faces/face8.jpg" alt="">
                                    </figure>
                                </a>
                                <a href="javascript:;" class="col-md-4 ps-1 pe-1">
                                    <figure class="mb-0">
                                        <img class="img-fluid rounded" src="https://www.nobleui.com/html/template/assets/images/faces/face9.jpg" alt="">
                                    </figure>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 grid-margin">
                    <div class="card rounded">
                        <div class="">
                            <div class="modal-header">
                                <h6 class="tx-11 fw-bolder text-uppercase">Others in this branch</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    <img class="img-xs rounded-circle" src="../../../assets/images/faces/face2.jpg" alt="">
                                    <div class="ms-2">
                                        <p>Mike Popescu</p>
                                        <p class="tx-11 text-muted">12 Mutual Friends</p>
                                    </div>
                                </div>
                                <button class="btn btn-icon border-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></button>
                            </div>
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    <img class="img-xs rounded-circle" src="../../../assets/images/faces/face3.jpg" alt="">
                                    <div class="ms-2">
                                        <p>Mike Popescu</p>
                                        <p class="tx-11 text-muted">12 Mutual Friends</p>
                                    </div>
                                </div>
                                <button class="btn btn-icon border-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></button>
                            </div>
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    <img class="img-xs rounded-circle" src="../../../assets/images/faces/face4.jpg" alt="">
                                    <div class="ms-2">
                                        <p>Mike Popescu</p>
                                        <p class="tx-11 text-muted">12 Mutual Friends</p>
                                    </div>
                                </div>
                                <button class="btn btn-icon border-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></button>
                            </div>
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    <img class="img-xs rounded-circle" src="../../../assets/images/faces/face5.jpg" alt="">
                                    <div class="ms-2">
                                        <p>Mike Popescu</p>
                                        <p class="tx-11 text-muted">12 Mutual Friends</p>
                                    </div>
                                </div>
                                <button class="btn btn-icon border-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></button>
                            </div>
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    <img class="img-xs rounded-circle" src="../../../assets/images/faces/face6.jpg" alt="">
                                    <div class="ms-2">
                                        <p>Mike Popescu</p>
                                        <p class="tx-11 text-muted">12 Mutual Friends</p>
                                    </div>
                                </div>
                                <button class="btn btn-icon border-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></button>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a class="btn btn-light border-0">View more</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- right wrapper end -->
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
