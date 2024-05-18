@extends('layouts.master-layout')
@section('title')
    Newsfeed
@endsection
@section('current-page')
    Newsfeed
@endsection
@section('extra-styles')
    <link href="/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/parsley.css" rel="stylesheet" type="text/css"/>
    <style>
        .text-danger {
            color: #ff0000 !important;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row profile-body">
            <div class="col-md-9 col-xl-9">
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
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item expandContent">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Memo</span>
                                    </a>
                                </li>
                                <li class="nav-item expandContent">
                                    <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Announcement</span>
                                    </a>
                                </li>
                                <li class="nav-item expandContent">
                                    <a class="nav-link" data-bs-toggle="tab" href="#settings1" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                        <span class="d-none d-sm-block">Message</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content p-3 text-muted tabContentArea">
                                <div class="tab-pane active" id="home1" role="tabpanel">
                                    @include('timeline.partials._memo-form')
                                </div>
                                <div class="tab-pane" id="profile1" role="tabpanel">
                                    @include('timeline.partials._announcement-form')
                                </div>
                                <div class="tab-pane" id="settings1" role="tabpanel">
                                    @include('timeline.partials._message-form')
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xl-12 middle-wrapper">
                    <div class="row">
                        @foreach($posts as $post)
                            <div class="col-md-12 grid-margin">
                                <div class="card rounded" style="border-top:1px dotted #293140;">
                                    <div class="modal-header" style="border-bottom: 1px solid #cccdd1 !important;">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-4">
                                                <img class="avatar-xs rounded-circle"
                                                     src="{{url('storage/'.$post->getAuthor->image ?? 'avatar.png')}}"
                                                     alt="{{$post->getAuthor->first_name ?? '' }}" class="avatar-sm">
                                            </div>

                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="text-truncate font-size-15">
                                                    <a href="{{ route('read-timeline-post', $post->p_slug) }}">{{$post->p_title ?? '' }}</a>
                                                </h5>
                                                <p class="text-muted"> <i class="bx bx-user align-middle text-info me-1"></i> {{ $post->getAuthor->title ?? ''  }} {{ $post->getAuthor->first_name ?? ''  }} {{ $post->getAuthor->last_name ?? ''  }} | <i class="bx bx-calendar align-middle text-danger me-1"></i> {{ date('d M, Y h:i a', strtotime($post->created_at)) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        {!! strlen(strip_tags($post->p_content)) > 150 ? substr(strip_tags($post->p_content), 0,150).'...<a href='. route('read-timeline-post', $post->p_slug).'>Read more</a>' : strip_tags($post->p_content) !!}
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex post-actions">
                                            <a href="javascript:;" class="d-flex align-items-center text-muted me-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <span class="d-none d-md-block ms-2"> {{ number_format($post->getPostViews->count()) }} View{{$post->getPostViews->count() > 1 ? 's' : null}}</span>
                                            </a>
                                            <a href="javascript:;" class="d-flex align-items-center text-muted me-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-message-square icon-md">
                                                    <path
                                                        d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                                </svg>
                                                <span class="d-none d-md-block ms-2">{{ number_format($post->getPostComments->count()) }} Comment{{$post->getPostComments->count() > 1 ? 's' : null}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-md-12 d-flex justify-content-center">
                            {{$posts->links()}}
                        </div>

                    </div>
                </div>
            </div>
            <div class="d-none d-xl-block col-xl-3">
                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="card rounded">
                            <div class="">
                                <div class="modal-header">
                                    <h6 class="tx-11 fw-bolder text-uppercase">Upcoming Events</h6>
                                </div>
                            </div>
                            <div class="card-body">
                                @foreach($events->take(6) as $event)
                                    <div class="row ms-0 me-0 mb-3" style="border-bottom: 1px solid #cccdd1;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h6 class="fs-14"><a href="{{ route('show-appointment-details', $event->slug) }}">{{$event->note ?? null }}</a></h6>
                                                <p class="mb-0"><span style="color: #34c38f">{{date('d M, Y', strtotime($event->event_date))}}</span> - <span style="color: #ff0000;">{{date('d M, Y', strtotime($event->end_date))}}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route("show-appointments") }}" class="btn btn-light border-0">Show all</a>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 grid-margin">
                        <div class="card rounded">
                            <div class="">
                                <div class="modal-header">
                                    <h6 class="tx-11 fw-bolder text-uppercase">Upcoming Birthdays</h6>
                                </div>
                            </div>
                            <div class="card-body">
                                @foreach($birthdays as $birth)
                                    <div class="row ms-0 me-0 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <img class="rounded avatar-sm" src="{{url('storage/'.$birth->image ?? 'avatar.png')}}"
                                                     alt="{{$birth->first_name ?? '' }}">
                                            </div>
                                            <div class="flex-grow-1" style="margin-bottom: 5px;">
                                                <h6 class="fs-14"><a href="{{ route("user-profile", $birth->slug) }}">{{$birth->title ?? '' }} {{$birth->first_name ?? '' }} {{$birth->last_name ?? '' }}</a></h6>
                                                <p class="mb-0"> {{ date('d F', strtotime($birth->birth_date)) ?? '' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route("birthdays") }}" class="btn btn-light border-0">Show all</a>
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
    <script src="/assets/libs/select2/js/select2.min.js"></script>
    <script src="/assets/js/pages/form-advanced.init.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.0/html2pdf.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.from-branch').hide();
            $('.from-region').hide();
            $('.from-persons').hide();

            $('.tabContentArea').hide();

            $('.memoTo').on('change', function () {
                let selection = $(this).val();
                console.log(selection)
                switch (parseInt(selection)) {
                    case 1:
                        $('.from-branch').hide();
                        $('.from-region').hide();
                        $('.from-persons').hide();
                        break;
                    case 2:
                        $('.from-branch').show();
                        $('.from-region').hide();
                        $('.from-persons').hide();
                        break;
                    case 3:
                        $('.from-branch').hide();
                        $('.from-region').show();
                        $('.from-persons').hide();
                        break;
                    case 4:
                        $('.from-branch').hide();
                        $('.from-region').hide();
                        $('.from-persons').show();
                        break;
                }
            });


            $(document).on('click', '.expandContent', function () {
                if ($('.tabContentArea:visible').length) {
                    $('.tabContentArea').hide();
                } else {
                    $('.tabContentArea').show();

                }
            });
            $('.content').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ]

            });
        });
    </script>

@endsection
