
@extends('layouts.master-layout')
@section('current-page')
    <small>Marketing > Compose Message</small>
@endsection
@section('extra-styles')
    <link href="/css/parsley.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">

                    <div class="card-body">
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
                        @include('followup.partial._top-navigation')
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('marketing-messaging')}}"  class="btn btn-primary"> Messages <i class="bx bxs-envelope"></i> </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card-header">
                                        Compose Message
                                    </div>
                                    <form autocomplete="off" class="mt-3" action="{{route('marketing-compose-messaging')}}" enctype="multipart/form-data" method="post" id="leadForm">
                                        @csrf
                                        <div class="form-group mt-1">
                                            <label for="">Subject <span class="text-danger">*</span></label>
                                            <input type="text" data-parsley-required-message="What's the subject of this message?" required name="subject" value="{{old('subject')}}" placeholder="Subject" class="form-control">
                                            @error('subject') <i class="text-danger">{{$message}}</i>@enderror
                                        </div>
                                        <div class="form-group mt-1">
                                            <label for="">To: <span class="text-danger">*</span></label>
                                            <select name="to[]" data-parsley-required-message="Who do you intend sending this message to?" multiple required  class="form-control select2">
                                                <option selected disabled>--Select recipient(s)--</option>
                                                @foreach($clients as $client)
                                                    <option value="{{$client->id}}">{{$client->first_name ?? '' }} {{$client->last_name ?? '' }}</option>
                                                @endforeach
                                            </select>
                                            @error('to') <i class="text-danger">{{$message}}</i>@enderror
                                        </div>
                                        <div class="form-group mt-1">
                                            <label for="">Attachment <small class="">(Optional)</small></label> <br>
                                            <input type="file" name="attachment" value="{{old('attachment')}}" class="form-control">
                                            @error('attachment') <i class="text-danger">{{$message}}</i>@enderror
                                        </div>
                                        <div class="form-group mt-1">
                                            <label for="">Message <span class="text-danger">*</span></label>
                                            <textarea name="message"  id="message" style="resize: none;" placeholder="Type message here..." class="form-control">{{old('message')}}</textarea>
                                            @error('message') <i class="text-danger">{{$message}}</i>@enderror
                                        </div>
                                        <div class="form-group d-flex justify-content-center mt-3">
                                            <div class="btn-group">
                                                <button type="submit"  class="btn btn-primary  waves-effect waves-light">Send Message <i class="bx bx-right-arrow"></i> </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-header">
                                        How to...
                                    </div>
                                    <p class="mt-3">
                                        Send an email to {{env('APP_NAME')}} members about upcoming events, competitions, schedule changes and other
                                        relevant information.
                                    </p>
                                    <ul>
                                        <li>Enter the subject of your email</li>
                                        <li>Choose from the list who you want to send this message to. This could be a list of people.</li>
                                        <li>The <strong>attachment</strong>  field is optional. You can attach a file to be shared with this email.</li>
                                        <li>Finally, compose your message and hit the send button to send it out to recipients.</li>
                                    </ul>
                                    <p>How simple is that? Very... right?</p>
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
    <script src="/js/parsley.js"></script>
    <script src="/js/tinymce/tinymce.min.js"></script>
    <script src="/assets/libs/select2/js/select2.min.js"></script>
    <script src="/assets/js/pages/form-advanced.init.js"></script>
    <script>
        $(document).ready(function(){
            $('#leadForm').parsley().on('field:validated', function() {
                var ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            })
                .on('form:submit', function() {
                    return true;
                });
            tinymce.init({
                selector: 'textarea',
                height: 350,
                promotion: false,
                menu: {

                },
            });
        })


    </script>
@endsection
