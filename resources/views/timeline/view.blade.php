@extends('layouts.master-layout')
@section('title')
{{$type ?? '' }}
@endsection
@section('current-page')
{{$type ?? '' }}
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
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <div class="card">
                                <div class="card-body border-bottom">
                                    <div class="d-flex">
                                        <img src="/assets/drive/logo/logo-dark.png" alt="{{ env("APP_NAME") }}" height="74" width="74">
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="fw-semibold">{{Auth::user()->getUserOrganization->organization_name ?? ''  }}</h5>
                                            <ul class="list-unstyled hstack gap-2 mb-0">
                                                <li>
                                                    <i class="bx bx-message"></i> <span class="text-muted">{{Auth::user()->getUserOrganization->email ?? ''  }}</span>
                                                </li>
                                                <li>
                                                    <i class="bx bx-phone-call"></i> <span class="text-muted">{{Auth::user()->getUserOrganization->phone_no ?? ''  }}</span>
                                                </li>
                                                <li>
                                                    <i class="bx bx-building-house"></i> <span class="text-muted">{{Auth::user()->getUserOrganization->address ?? ''  }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <th scope="col">To:</th>
                                                <td scope="col">
                                                    @if($scope == 4)
                                                        @foreach($users as $user)
                                                            {{$user->title ?? '' }} {{ $user->first_name ?? ''  }} {{ $user->last_name ?? '' }},
                                                        @endforeach
                                                    @elseif($scope == 2)
                                                        @foreach($branches as $branch)
                                                            {{$branch->cb_name ?? '' }}
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">From:</th>
                                                <td>{{$post->getAuthor->title ?? '' }} {{$post->getAuthor->first_name ?? '' }} {{$post->getAuthor->last_name ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Position:</th>
                                                <td>12</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Date:</th>
                                                <td><span class="badge badge-soft-success">{{date('d M, Y h:i a', strtotime($post->created_at))}}</span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <h5 class="fw-semibold mb-3">Subject: {{ $post->p_title ?? ''  }}</h5>
                                    {!! $post->p_content ?? '' !!}


                                    <div class="mt-4 d-flex justify-content-end">
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item mt-1">
                                                <a href="javascript:void(0)" class="btn btn-outline-danger btn-hover"><i class="uil uil-google"></i> Print </a>
                                            </li>
                                        </ul>
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



@endsection
