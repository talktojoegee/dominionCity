@extends('layouts.master-layout')
@section('current-page')
    Schedule SMS
@endsection
@section('title')
    Schedule SMS
@endsection
@section('extra-styles')
    <link href="/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="">
                    @if(session()->has('success'))
                        <div class="alert alert-success mb-4">
                            <strong>Great!</strong>
                            <hr class="message-inner-separator">
                            <p>{!! session()->get('success') !!}</p>
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-warning mb-4">
                            <strong>Whoops!</strong>
                            <hr class="message-inner-separator">
                            <p>{!! session()->get('error') !!}</p>
                        </div>
                    @endif
                        <div class="modal-header">

                            <div class="modal-title text-uppercase">Schedule SMS </div>
                        </div>
                    <div class="card-body">
                        <form action="{{route('preview-message')}}" method="get">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12 col-sm-12 col-lg-12 mb-3">
                                            <p><strong class="text-danger" style="color: #ff0000 !important;">Note:</strong> Messages scheduled or sent after 7:00pm will be delivered the next day at about 08:15am. This is due to the time restriction on SMS delivery on the bulk route to MTN</p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label d-flex justify-content-between">Sender ID
                                                    <small><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#newSenderIdModal">Add New Sender ID</a></small>
                                                </label>
                                                <select name="senderId" id="senderId" class="form-control select2">
                                                    <option value="SMS Channel" selected>SMS Channel</option>
                                                    @foreach(Auth::user()->getUserSenderIds as $id)
                                                        <option value="{{$id->sender_id}}">{{$id->sender_id}}</option>
                                                    @endforeach
                                                </select>
                                                @error('senderId') <i class="text-danger">{{$message}}</i>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <div class="form-check form-switch mb-3" dir="ltr" >
                                                <input class="form-check-input" type="checkbox" name="recurring" id="recurring">
                                                <label class="form-check-label" for="recurring">Recurring task?</label>
                                            </div>
                                            <div id="specific">
                                                <div class="form-group">
                                                    <label class="" >
                                                        Schedule Later <small>(Pick Date & Time)</small>
                                                    </label>
                                                </div>
                                                <input class="form-control" name="dateTime" type="datetime-local" id="scheduleInput">
                                            </div>
                                            <div id="recurringValues" class="mt-4">
                                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <span class="input-group-btn input-group-prepend">
                                                        <button class="btn btn-primary bootstrap-touchspin-down" type="button">Choose Day</button>
                                                    </span>
                                                    <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                                        <select name="frequency" id="frequency" class="form-control select2">
                                                                <optgroup label="Once A Week">
                                                                @foreach($frequencies as $frequency)
                                                                    @switch($frequency->letter)
                                                                        @case('d')
                                                                            <option value="{{ $frequency->id }}">{{$frequency->label ?? '' }}</option>
                                                                        @break
                                                                    @endswitch
                                                                 @endforeach
                                                                </optgroup>
                                                                <optgroup label="Monthly">
                                                                    @foreach($frequencies as $frequency)
                                                                        @switch($frequency->letter)
                                                                            @case('m')
                                                                                <option value="{{ $frequency->id }}">{{$frequency->label ?? '' }}</option>
                                                                            @break
                                                                        @endswitch
                                                                    @endforeach
                                                                </optgroup>
                                                                <optgroup label="Others">
                                                                    @foreach($frequencies as $frequency)
                                                                        @switch($frequency->letter)
                                                                            @case('o')
                                                                                <option value="{{ $frequency->id }}">{{$frequency->label ?? '' }}</option>
                                                                            @break
                                                                        @endswitch
                                                                    @endforeach
                                                                </optgroup>
                                                        </select>
                                                    </span>
                                                    <span class="input-group-btn input-group-append">
                                                        <button class="btn btn-primary bootstrap-touchspin-up" type="button">Time</button>
                                                    </span>
                                                    <input  type="time" name="timeLot"  class="form-control">
                                                    <input type="hidden" name="type" value="2"> <!-- Schedule -->

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="from-phone-group">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label d-flex justify-content-between">Phone Group
                                                    <small><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#newPhoneGroupModal">Create New Phone Group</a></small>
                                                </label>
                                                <select name="phonegroup[]" id="phonegroup" class="select2 form-control select2-multiple" multiple="multiple">
                                                    <option disabled selected>--Select Phone Group--</option>
                                                    @foreach(Auth::user()->getUserPhoneGroups as $group)
                                                        <option value="{{$group->id}}">{{$group->group_name ?? '' }} ({{$group->getNumberOfContacts($group->id)}})</option>
                                                    @endforeach
                                                </select>
                                                @error('phonegroup') <i class="text-danger">{{$message}}</i>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="from-phone-numbers">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Numbers</label>
                                                <textarea name="phone_numbers" id="phone_numbers" style="resize: none" placeholder="Enter phone numbers separated by comma"
                                                          class="form-control">{{old('phone_numbers')}}</textarea>
                                                @error('phone_numbers') <i class="text-danger">{{$message}}</i>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="from-message">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Compose message</label>
                                                <textarea name="message" rows="5" id="message" style="resize: none" placeholder="Compose message here..."
                                                          class="form-control">{{old('message')}}</textarea>
                                                @error('message') <i class="text-danger">{{$message}}</i>@enderror
                                                <p class="text-right text-danger" id="character-counter">0</p>
                                                <span><strong class="text-danger">Note: </strong> One page of message consists of <code>160</code> characters.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary w-50">Preview Message <i class="bx bxs-right-arrow"></i> </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="newSenderIdModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add New Send ID</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('create-senders')}}" method="post" autocomplete="off">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h5 >Sender ID Registration</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Sender ID</label>
                                            <input type="text" maxlength="11" class="form-control" value="{{old('sender_id') }}"  name="sender_id" placeholder="Enter Your Sender ID (maximum of 11 characters)">
                                            @error('sender_id') <i class="text-danger">{{$message}}</i>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="from-phone-group">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Purpose <small>(Optional)</small></label>
                                            <textarea name="purpose" id="purpose" style="resize: none;"
                                                      class="form-control" placeholder="What does this ID imply?">{{old('purpose')}}</textarea>
                                            @error('purpose') <i class="text-danger">{{$message}}</i>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ">
                                <button type="submit" class="btn btn-lg btn-custom w-100">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div id="newPhoneGroupModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Create New Phone Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('phone-groups')}}" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Phone Group Name</label>
                                    <input type="text" placeholder="Phone Group Name" name="group_name" value="{{old('group_name')}}" class="form-control">
                                    @error('group_name')<i class="text-danger">{{$message}}</i>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Contact</label>
                                    <textarea name="phone_numbers" id="contact" cols="30" rows="10" style="resize: none" placeholder="Enter a list of phone numbers separated by comma." class="form-control">{{old('phone_numbers')}}</textarea>
                                    @error('phone_numbers') <i class="text-danger mt-2">{{$message}}</i>@enderror
                                </div>
                                <div class="form-group d-flex justify-content-center mt-2">
                                    <button type="submit" class="btn btn-sm btn-primary w-50"> Submit <i class="bx bxs-right-arrow mr-2"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script src="/assets/libs/select2/js/select2.min.js"></script>
    <script src="/assets/js/pages/form-advanced.init.js"></script>
    <script>
        $(document).ready(function(){
            $('#recurringValues').hide();
            $('#specific').show();

            $(document).on('keydown','#message', function() {
                var leng = $(this).val();
                $('#character-counter').text(leng.length+1);
            });
            $(document).on('blur','#message', function() {
                var leng = $(this).val();
                $('#character-counter').text(leng.length+1);
            });

            $(document).on('change', '#recurring', function(e){
                if($(this).is(':checked')){
                    $('#recurringValues').show();
                    $('#specific').hide();
                }else{
                    $('#recurringValues').hide();
                    $('#specific').show();
                }
            });
        });
    </script>
@endsection
