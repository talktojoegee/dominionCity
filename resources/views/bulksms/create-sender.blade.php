@extends('layouts.master-layout')
@section('current-page')
    Register Sender ID
@endsection
@section('title')
    Register Sender ID
@endsection
@section('extra-styles')

@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-6 offset-md-3">
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
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Whoops!</strong>
                            <hr class="message-inner-separator">
                            <p>{!! session()->get('error') !!}</p>
                        </div>
                    @endif
                    <div class="card-body">
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
                                                <label class="form-label">Purpose </label>
                                                <textarea name="purpose" id="purpose" style="resize: none;"
                                                          class="form-control" placeholder="What will you use this sender ID for...?">{{old('purpose')}}</textarea>
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')

@endsection
