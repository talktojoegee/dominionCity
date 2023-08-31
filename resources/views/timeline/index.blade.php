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
                                <div class="card rounded">
                                    <div class="modal-header" style="border-bottom: 1px solid #cccdd1 !important;">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-4">
                                                <img class="avatar-xs rounded-circle"
                                                     src="{{url('storage/'.$post->getAuthor->image ?? 'avatar.png')}}"
                                                     alt="{{$post->getAuthor->first_name ?? '' }}" class="avatar-sm">
                                            </div>

                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="text-truncate font-size-15">{{$post->p_title ?? '' }}</h5>
                                                <p class="text-muted">Separate existence is a myth. For science, music,
                                                    sport, etc.</p>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                               aria-haspopup="true" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-more-horizontal icon-lg pb-3px">
                                                    <circle cx="12" cy="12" r="1"></circle>
                                                    <circle cx="19" cy="12" r="1"></circle>
                                                    <circle cx="5" cy="12" r="1"></circle>
                                                </svg>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                <a class="dropdown-item d-flex align-items-center" href="javascript:;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                         class="feather feather-meh icon-sm me-2">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <line x1="8" y1="15" x2="16" y2="15"></line>
                                                        <line x1="9" y1="9" x2="9.01" y2="9"></line>
                                                        <line x1="15" y1="9" x2="15.01" y2="9"></line>
                                                    </svg>
                                                    <span class="">Unfollow</span></a>
                                                <a class="dropdown-item d-flex align-items-center" href="javascript:;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                         class="feather feather-corner-right-up icon-sm me-2">
                                                        <polyline points="10 9 15 4 20 9"></polyline>
                                                        <path d="M4 20h7a4 4 0 0 0 4-4V4"></path>
                                                    </svg>
                                                    <span class="">Go to post</span></a>
                                                <a class="dropdown-item d-flex align-items-center" href="javascript:;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                         class="feather feather-share-2 icon-sm me-2">
                                                        <circle cx="18" cy="5" r="3"></circle>
                                                        <circle cx="6" cy="12" r="3"></circle>
                                                        <circle cx="18" cy="19" r="3"></circle>
                                                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                                                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                                                    </svg>
                                                    <span class="">Share</span></a>
                                                <a class="dropdown-item d-flex align-items-center" href="javascript:;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                         class="feather feather-copy icon-sm me-2">
                                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                                        <path
                                                            d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                                    </svg>
                                                    <span class="">Copy link</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        {!! strlen(strip_tags($post->p_content)) > 150 ? substr(strip_tags($post->p_content), 0,150).'...<a href='.$post->p_id.'>Read more</a>' : strip_tags($post->p_content) !!}
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex post-actions">
                                            <a href="javascript:;" class="d-flex align-items-center text-muted me-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-heart icon-md">
                                                    <path
                                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                                </svg>
                                                <p class="d-none d-md-block ms-2">Like</p>
                                            </a>
                                            <a href="javascript:;" class="d-flex align-items-center text-muted me-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-message-square icon-md">
                                                    <path
                                                        d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                                </svg>
                                                <p class="d-none d-md-block ms-2">Comment</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="d-none d-xl-block col-xl-3">
                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="card rounded">
                            <div class="">
                                <div class="modal-header">
                                    <h6 class="tx-11 fw-bolder text-uppercase">Upcoming Birthdays</h6>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row ms-0 me-0 mb-3" style="border-bottom: 1px solid #cccdd1;">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <img class="rounded avatar-sm" src="assets/images/users/avatar-5.jpg"
                                                 alt="Generic placeholder image">
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="fs-14">Pastor Chukwuemeka Oluwaleseun Yusuf Adams</h6>
                                            <p class="mb-0">15th December</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ms-0 me-0">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <img class="rounded avatar-sm" src="assets/images/users/avatar-5.jpg"
                                                 alt="Generic placeholder image">
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="fs-14">Pastor Chukwuemeka Oluwaleseun Yusuf Adams</h6>
                                            <p class="mb-0">15th December</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 grid-margin">
                        <div class="card rounded">
                            <div class="">
                                <div class="modal-header">
                                    <h6 class="tx-11 fw-bolder text-uppercase">Recent Activities</h6>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                    <div class="d-flex align-items-center hover-pointer">
                                        <img class="img-xs rounded-circle" src="../../../assets/images/faces/face2.jpg"
                                             alt="">
                                        <div class="ms-2">
                                            <p>Mike Popescu</p>
                                            <p class="tx-11 text-muted">12 Mutual Friends</p>
                                        </div>
                                    </div>
                                    <button class="btn btn-icon border-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-user-plus">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="8.5" cy="7" r="4"></circle>
                                            <line x1="20" y1="8" x2="20" y2="14"></line>
                                            <line x1="23" y1="11" x2="17" y2="11"></line>
                                        </svg>
                                    </button>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <a class="btn btn-light border-0">View more</a>
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
