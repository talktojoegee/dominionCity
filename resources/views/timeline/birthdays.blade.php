@extends('layouts.master-layout')
@section('title')
    Birthdays
@endsection
@section('current-page')
    Birthdays
@endsection
@section('extra-styles')

@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row profile-body">
            <div class="col-md-12 col-xl-12">
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
                <div class="col-md-12 col-xl-12 middle-wrapper">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-12 col-lg-12 col-sm-12 mb-4">
                                    <div class="modal-header">January Celebrants</div>
                                </div>
                                @foreach($users as $user)
                                    @if($user->birth_month == 1)
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="mb-4">
                                                        <img class="rounded-circle avatar-sm" src="{{url('storage/'.$user->image ?? 'avatar.png')}}" alt="{{$user->first_name ?? '' }}">
                                                    </div>
                                                    <h5 class="font-size-15 mb-1"><a href="{{ route("user-profile", $user->slug) }}" class="text-dark">{{$user->title ?? '' }} {{$user->first_name ?? '' }} {{$user->last_name ?? '' }}</a></h5>
                                                    <p class="text-muted">{{$user->getUserRole->name ?? '' }}</p>

                                                    <div>
                                                        <a href="{{ route("user-profile", $user->slug) }}" class="badge bg-primary font-size-11 m-1">{{date('d F', strtotime($user->birth_date))}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="col-md-12 col-lg-12 col-sm-12 mb-4">
                                    <div class="modal-header">February Celebrants</div>
                                </div>
                                @foreach($users as $user)
                                    @if($user->birth_month == 2)
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="mb-4">
                                                        <img class="rounded-circle avatar-sm" src="{{url('storage/'.$user->image ?? 'avatar.png')}}" alt="{{$user->first_name ?? '' }}">
                                                    </div>
                                                    <h5 class="font-size-15 mb-1"><a href="{{ route("user-profile", $user->slug) }}" class="text-dark">{{$user->title ?? '' }} {{$user->first_name ?? '' }} {{$user->last_name ?? '' }}</a></h5>
                                                    <p class="text-muted">{{$user->getUserRole->name ?? '' }}</p>

                                                    <div>
                                                        <a href="{{ route("user-profile", $user->slug) }}" class="badge bg-primary font-size-11 m-1">{{date('d F', strtotime($user->birth_date))}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="col-md-12 col-lg-12 col-sm-12 mb-4">
                                    <div class="modal-header">March Celebrants</div>
                                </div>
                                @foreach($users as $user)
                                    @if($user->birth_month == 3)
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="mb-4">
                                                        <img class="rounded-circle avatar-sm" src="{{url('storage/'.$user->image ?? 'avatar.png')}}" alt="{{$user->first_name ?? '' }}">
                                                    </div>
                                                    <h5 class="font-size-15 mb-1"><a href="{{ route("user-profile", $user->slug) }}" class="text-dark">{{$user->title ?? '' }} {{$user->first_name ?? '' }} {{$user->last_name ?? '' }}</a></h5>
                                                    <p class="text-muted">{{$user->getUserRole->name ?? '' }}</p>

                                                    <div>
                                                        <a href="{{ route("user-profile", $user->slug) }}" class="badge bg-primary font-size-11 m-1">{{date('d F', strtotime($user->birth_date))}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="col-md-12 col-lg-12 col-sm-12 mb-4">
                                    <div class="modal-header">April Celebrants</div>
                                </div>
                                @foreach($users as $user)
                                    @if($user->birth_month == 4)
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="mb-4">
                                                        <img class="rounded-circle avatar-sm" src="{{url('storage/'.$user->image ?? 'avatar.png')}}" alt="{{$user->first_name ?? '' }}">
                                                    </div>
                                                    <h5 class="font-size-15 mb-1"><a href="{{ route("user-profile", $user->slug) }}" class="text-dark">{{$user->title ?? '' }} {{$user->first_name ?? '' }} {{$user->last_name ?? '' }}</a></h5>
                                                    <p class="text-muted">{{$user->getUserRole->name ?? '' }}</p>

                                                    <div>
                                                        <a href="{{ route("user-profile", $user->slug) }}" class="badge bg-primary font-size-11 m-1">{{date('d F', strtotime($user->birth_date))}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="col-md-12 col-lg-12 col-sm-12 mb-4">
                                    <div class="modal-header">May Celebrants</div>
                                </div>
                                @foreach($users as $user)
                                    @if($user->birth_month == 5)
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="mb-4">
                                                        <img class="rounded-circle avatar-sm" src="{{url('storage/'.$user->image ?? 'avatar.png')}}" alt="{{$user->first_name ?? '' }}">
                                                    </div>
                                                    <h5 class="font-size-15 mb-1"><a href="{{ route("user-profile", $user->slug) }}" class="text-dark">{{$user->title ?? '' }} {{$user->first_name ?? '' }} {{$user->last_name ?? '' }}</a></h5>
                                                    <p class="text-muted">{{$user->getUserRole->name ?? '' }}</p>

                                                    <div>
                                                        <a href="{{ route("user-profile", $user->slug) }}" class="badge bg-primary font-size-11 m-1">{{date('d F', strtotime($user->birth_date))}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="col-md-12 col-lg-12 col-sm-12 mb-4">
                                    <div class="modal-header">June Celebrants</div>
                                </div>
                                @foreach($users as $user)
                                    @if($user->birth_month == 6)
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="mb-4">
                                                        <img class="rounded-circle avatar-sm" src="{{url('storage/'.$user->image ?? 'avatar.png')}}" alt="{{$user->first_name ?? '' }}">
                                                    </div>
                                                    <h5 class="font-size-15 mb-1"><a href="{{ route("user-profile", $user->slug) }}" class="text-dark">{{$user->title ?? '' }} {{$user->first_name ?? '' }} {{$user->last_name ?? '' }}</a></h5>
                                                    <p class="text-muted">{{$user->getUserRole->name ?? '' }}</p>

                                                    <div>
                                                        <a href="{{ route("user-profile", $user->slug) }}" class="badge bg-primary font-size-11 m-1">{{date('d F', strtotime($user->birth_date))}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="col-md-12 col-lg-12 col-sm-12 mb-4">
                                    <div class="modal-header">July Celebrants</div>
                                </div>
                                @foreach($users as $user)
                                    @if($user->birth_month == 7)
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="mb-4">
                                                        <img class="rounded-circle avatar-sm" src="{{url('storage/'.$user->image ?? 'avatar.png')}}" alt="{{$user->first_name ?? '' }}">
                                                    </div>
                                                    <h5 class="font-size-15 mb-1"><a href="{{ route("user-profile", $user->slug) }}" class="text-dark">{{$user->title ?? '' }} {{$user->first_name ?? '' }} {{$user->last_name ?? '' }}</a></h5>
                                                    <p class="text-muted">{{$user->getUserRole->name ?? '' }}</p>

                                                    <div>
                                                        <a href="{{ route("user-profile", $user->slug) }}" class="badge bg-primary font-size-11 m-1">{{date('d F', strtotime($user->birth_date))}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="col-md-12 col-lg-12 col-sm-12 mb-4">
                                    <div class="modal-header">August Celebrants</div>
                                </div>
                                @foreach($users as $user)
                                    @if($user->birth_month == 8)
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="mb-4">
                                                        <img class="rounded-circle avatar-sm" src="{{url('storage/'.$user->image ?? 'avatar.png')}}" alt="{{$user->first_name ?? '' }}">
                                                    </div>
                                                    <h5 class="font-size-15 mb-1"><a href="{{ route("user-profile", $user->slug) }}" class="text-dark">{{$user->title ?? '' }} {{$user->first_name ?? '' }} {{$user->last_name ?? '' }}</a></h5>
                                                    <p class="text-muted">{{$user->getUserRole->name ?? '' }}</p>

                                                    <div>
                                                        <a href="{{ route("user-profile", $user->slug) }}" class="badge bg-primary font-size-11 m-1">{{date('d F', strtotime($user->birth_date))}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="col-md-12 col-lg-12 col-sm-12 mb-4">
                                    <div class="modal-header">September Celebrants</div>
                                </div>
                                @foreach($users as $user)
                                    @if($user->birth_month == 9)
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="mb-4">
                                                        <img class="rounded-circle avatar-sm" src="{{url('storage/'.$user->image ?? 'avatar.png')}}" alt="{{$user->first_name ?? '' }}">
                                                    </div>
                                                    <h5 class="font-size-15 mb-1"><a href="{{ route("user-profile", $user->slug) }}" class="text-dark">{{$user->title ?? '' }} {{$user->first_name ?? '' }} {{$user->last_name ?? '' }}</a></h5>
                                                    <p class="text-muted">{{$user->getUserRole->name ?? '' }}</p>

                                                    <div>
                                                        <a href="{{ route("user-profile", $user->slug) }}" class="badge bg-primary font-size-11 m-1">{{date('d F', strtotime($user->birth_date))}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="col-md-12 col-lg-12 col-sm-12 mb-4">
                                    <div class="modal-header">October Celebrants</div>
                                </div>
                                @foreach($users as $user)
                                    @if($user->birth_month == 10)
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="mb-4">
                                                        <img class="rounded-circle avatar-sm" src="{{url('storage/'.$user->image ?? 'avatar.png')}}" alt="{{$user->first_name ?? '' }}">
                                                    </div>
                                                    <h5 class="font-size-15 mb-1"><a href="{{ route("user-profile", $user->slug) }}" class="text-dark">{{$user->title ?? '' }} {{$user->first_name ?? '' }} {{$user->last_name ?? '' }}</a></h5>
                                                    <p class="text-muted">{{$user->getUserRole->name ?? '' }}</p>

                                                    <div>
                                                        <a href="{{ route("user-profile", $user->slug) }}" class="badge bg-primary font-size-11 m-1">{{date('d F', strtotime($user->birth_date))}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="col-md-12 col-lg-12 col-sm-12 mb-4">
                                    <div class="modal-header">November Celebrants</div>
                                </div>
                                @foreach($users as $user)
                                    @if($user->birth_month == 11)
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="mb-4">
                                                        <img class="rounded-circle avatar-sm" src="{{url('storage/'.$user->image ?? 'avatar.png')}}" alt="{{$user->first_name ?? '' }}">
                                                    </div>
                                                    <h5 class="font-size-15 mb-1"><a href="{{ route("user-profile", $user->slug) }}" class="text-dark">{{$user->title ?? '' }} {{$user->first_name ?? '' }} {{$user->last_name ?? '' }}</a></h5>
                                                    <p class="text-muted">{{$user->getUserRole->name ?? '' }}</p>

                                                    <div>
                                                        <a href="{{ route("user-profile", $user->slug) }}" class="badge bg-primary font-size-11 m-1">{{date('d F', strtotime($user->birth_date))}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="col-md-12 col-lg-12 col-sm-12 mb-4">
                                    <div class="modal-header">December Celebrants</div>
                                </div>
                                @foreach($users as $user)
                                    @if($user->birth_month == 12)
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="mb-4">
                                                        <img class="rounded-circle avatar-sm" src="{{url('storage/'.$user->image ?? 'avatar.png')}}" alt="{{$user->first_name ?? '' }}">
                                                    </div>
                                                    <h5 class="font-size-15 mb-1"><a href="{{ route("user-profile", $user->slug) }}" class="text-dark">{{$user->title ?? '' }} {{$user->first_name ?? '' }} {{$user->last_name ?? '' }}</a></h5>
                                                    <p class="text-muted">{{$user->getUserRole->name ?? '' }}</p>

                                                    <div>
                                                        <a href="{{ route("user-profile", $user->slug) }}" class="badge bg-primary font-size-11 m-1">{{date('d F', strtotime($user->birth_date))}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('extra-scripts')


@endsection
