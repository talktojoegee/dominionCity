
@extends('layouts.master-layout')
@section('current-page')
    <small>Marketing > Edit Automation</small>
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
                        <a href="{{route('marketing-automations')}}"  class="btn btn-primary">  Automations <i class="bx bxs-send"></i> </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card-header">
                                        Create Automation
                                    </div>
                                    <form autocomplete="off" class="mt-3" action="{{route('save-marketing-automation-changes')}}" enctype="multipart/form-data" method="post" id="leadForm">
                                        @csrf
                                        <div class="form-group mt-1">
                                            <label for="">Automation Title <span class="text-danger">*</span></label>
                                            <input type="text" data-parsley-required-message="What's the title of this automation?" required name="automationTitle" value="{{old('automationTitle', $automation->title )}}" placeholder="Automation Title" class="form-control">
                                            @error('automationTitle') <i class="text-danger">{{$message}}</i>@enderror
                                        </div>
                                        <div class="form-group mt-3 col-md-4">
                                            <label for="">Trigger Action: <span class="text-danger">*</span></label>
                                            <select name="triggerAction" data-parsley-required-message="Choose when this automation is triggered" required  class="form-control select2">
                                                <option selected disabled>--Select trigger--</option>
                                                <option value="1">Member Sign-up</option>
                                                <option value="2">Visitor Sign-up</option>
                                                <option value="3">New Lead</option>
                                                <option value="4">Membership Start</option>
                                                <option value="5">Promotion</option>
                                                <option value="6">Absence</option>
                                                <option value="6">Member Frozen</option>
                                                <option value="6">Member Cancelled</option>
                                                <option value="6">Manually Triggered</option>
                                            </select>
                                            <input type="hidden" name="automateId" value="{{$automation->id}}">
                                            @error('triggerAction') <i class="text-danger">{{$message}}</i>@enderror
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="">Period<span class="text-danger">*</span></label> <br>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" >Send After<small>(in days)</small></span>
                                                <input type="number" class="form-control" name="sendAfter" value="{{old('sendAfter',$automation->send_after)}}" placeholder="Send After">
                                                <span class="input-group-text" >Time</span>
                                                <input type="number" class="form-control" name="time" value="{{old('time',$automation->time )}}" placeholder="Time">
                                                <span class="input-group-text" >Type</span>
                                                <select name="type" class="form-control">
                                                    <option value="1">Email</option>
                                                    <option value="2">SMS/Text</option>
                                                </select>
                                            </div>
                                            @error('sendAfter') <i class="text-danger">{{$message}}</i>@enderror
                                            @error('time') <i class="text-danger">{{$message}}</i>@enderror
                                        </div>
                                        <div class="form-group mt-1">
                                            <label for="">Subject<span class="text-danger">*</span></label>
                                            <input type="text" data-parsley-required-message="Enter subject" required name="subject" value="{{old('subject', $automation->subject)}}" placeholder="Subject" class="form-control">
                                            @error('subject') <i class="text-danger">{{$message}}</i>@enderror
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="">Message <span class="text-danger">*</span></label>
                                            <textarea name="message"  id="message" style="resize: none;" placeholder="Type message here..." class="form-control">{{old('message', $automation->message)}}</textarea>
                                            @error('message') <i class="text-danger">{{$message}}</i>@enderror
                                        </div>
                                        <div class="form-group d-flex justify-content-center mt-3">
                                            <div class="btn-group">
                                                <button type="submit"  class="btn btn-primary  waves-effect waves-light">Save Automation <i class="bx bx-right-arrow"></i> </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-header">
                                        Placeholders
                                    </div>
                                    <p class="mt-3">
                                        Use any of the following placeholders in your automation. Our system will fill them up with the appropriate values.
                                    </p>
                                    <ul>
                                        <li><code>{name}</code> - Member's full name</li>
                                        <li><code>{first_name}</code> - Member's first name</li>
                                        <li><code>{last_name}</code> - Member's last name</li>
                                        <li><code>{email}</code> - Member's email address</li>
                                        <li><code>{mobile_no}</code> - Member's mobile number</li>
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
