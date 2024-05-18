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
                                            <tr class="table-light">
                                                <th scope="row">Date:</th>
                                                <td><span class="badge badge-soft-success">{{date('d M, Y h:i a', strtotime($post->created_at))}}</span></td>
                                            </tr>
                                            <tr class="table-light">
                                                <th scope="col">To: </th>
                                                <td scope="col">
                                                    @if($scope == 4)
                                                        @foreach($users as $user)
                                                            {{$user->title ?? '' }} {{ $user->first_name ?? ''  }} {{ $user->last_name ?? '' }},
                                                        @endforeach
                                                    @elseif($scope == 2)
                                                        @foreach($branches as $branch)
                                                            {{$branch->cb_name ?? '' }},
                                                        @endforeach
                                                    @elseif($scope == 1)
                                                        <span style="background: #f46a6a; padding:4px; color:#fff;">Everyone</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="table-light">
                                                <th scope="row">From:</th>
                                                <td>{{$post->getAuthor->title ?? '' }} {{$post->getAuthor->first_name ?? '' }} {{$post->getAuthor->last_name ?? '' }} <small>({{$post->getAuthor->getUserRole->name ?? '' }})</small></td>
                                            </tr>
                                            <tr class="table-light">
                                                <th scope="row">Subject:</th>
                                                <td>{{ $post->p_title ?? ''  }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-lg-12 col-sm-12 pl-4">
                                            {!! $post->p_content ?? '' !!}
                                        </div>
                                        @if($post->getAttachments->count() > 0)
                                        <div class="col-md-12 col-lg-12 col-sm-12">
                                            <div class="row">
                                                @foreach($post->getAttachments as $attachment)
                                                    <div class="col-md-4 col-sm-4">
                                                        <div class="avatar-sm">
                                                            <span
                                                                class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                                                <i class="bx bxs-file-doc"></i>
                                                            </span>
                                                        </div>

                                                        <h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">{{ strlen($attachment->pa_name) > 25 ?  substr($attachment->pa_name,0,22).'...' : $attachment->pa_name   }}</a>
                                                        </h5>
                                                        <small>Size
                                                            : {{ \App\Models\PostAttachment::formatFileSize($attachment->pa_size)  ?? '' }}
                                                        </small>

                                                        <div class="text-center">
                                                            <a href="{{ route('download-attachment', $attachment->pa_attachments) }}"
                                                               class="text-dark"><i class="bx bx-download h3 m-0"></i></a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    </div>




                                    <div class="row mt-4 ">
                                        <div class="col-md-12 col-lg-12 d-flex justify-content-end">
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item mt-1">
                                                    <a href="javascript:void(0)" id="printContent" class="btn btn-outline-danger btn-hover"><i class="uil uil-google"></i> Print </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 mt-3 bg-light p-3 comment">
                                            <h5>Comments <span class="bg-danger">({{number_format( $post->getPostComments->count() ) }})</span> </h5>
                                            <div style="height: {{$post->getPostComments->count() <= 0 ? 20 : 330}}px; overflow-y: scroll;">
                                                @if($post->getPostComments->count() <= 0)

                                                    <p class="text-center">This publication has no comment at the moment.</p>
                                                @else
                                                    @foreach($post->getPostComments as $comment)
                                                        <div class="d-flex py-3 border-top " style="border-bottom: 1px dotted #ccc;">
                                                            <div class="flex-shrink-0 me-3">
                                                                <div class="avatar-xs">
                                                                    <img src="{{url('storage/'.$comment->getUser->image)}}" alt="" class="img-fluid d-block rounded-circle">
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h5 class="font-size-14 mb-1">{{$comment->getUser->title ?? '' }} {{$comment->getUser->first_name ?? '' }} {{$comment->getUser->last_name ?? '' }}</h5>
                                                                {{ $comment->pc_comment ?? '' }}
                                                                <div>
                                                                    <a href="javascript: void(0);" class="text-success">{{ date('d M, Y h:ia', strtotime($comment->created_at)) }}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 comment">
                                            <div class="mt-4">
                                                <h5 class="font-size-16 mb-3">Leave a Comment</h5>
                                                <form action="{{route('post-comment')}}" method="post">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label  class="form-label">Comment</label>
                                                        <textarea name="comment"  class="form-control" style="resize: none;" placeholder="Type your comment here..." rows="3" spellcheck="false">{{ old('comment') }}</textarea>
                                                        @error('comment') <i class="text-danger">{{ $message }}</i> @enderror
                                                        <input type="hidden" name="post" value="{{ $post->p_id }}">
                                                    </div>
                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-success w-sm">Submit</button>
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

    <script>
        $(document).ready(function(){
            $('#printContent').on('click', function(e){
                e.preventDefault();
                $('#printContent').hide();
                $('.comment').hide();
                window.print();
                $('#printContent').show();
                $('.comment').show();
            });
        });
    </script>

@endsection
