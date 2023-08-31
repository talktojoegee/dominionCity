@extends('layouts.master-layout')
@section('current-page')
    API Settings
@endsection
@section('title')
    API Settings
@endsection
@section('extra-styles')

@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">How to Use Our API to Send Bulk SMS</h4>
                    <div class="">
                        <ul class="verti-timeline list-unstyled">
                            <li class="event-list">
                                <div class="event-timeline-dot">
                                    <i class="bx bx-right-arrow-circle"></i>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="bx bx-copy-alt h2 text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>
                                            <h5>Generate API Token</h5>
                                            <p class="text-muted">
                                                Send a POST/GET request to this URL -> (https://www.bulksmsnigeria.com/api/v1/sms/create) passing these values
                                                api_token
                                                from
                                                to
                                                body
                                                dnd (optional) . Use this to set your DND Management option.
                                                The available options are 1, 2, 3, 4, 5, 6, 7, and 8 or 'direct-refund', 'direct-hosted', 'hosted-sim', 'dual-backup', 'dual-dispatch', 'corporate', 'international' and 'otp'..
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="event-list">
                                <div class="event-timeline-dot">
                                    <i class="bx bx-right-arrow-circle"></i>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="bx bx-package h2 text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>
                                            <h5>Packed</h5>
                                            <p class="text-muted">To achieve this, it would be necessary to have uniform grammar.</p>

                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="event-list active">
                                <div class="event-timeline-dot">
                                    <i class="bx bx-right-arrow-circle bx-fade-right"></i>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="bx bx-car h2 text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>
                                            <h5>Shipped</h5>
                                            <p class="text-muted">It will be as simple as Occidental in fact, it will be Occidental..</p>

                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="event-list">
                                <div class="event-timeline-dot">
                                    <i class="bx bx-right-arrow-circle"></i>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="bx bx-badge-check h2 text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>
                                            <h5>Delivered</h5>
                                            <p class="text-muted">To an English person, it will seem like simplified English.</p>

                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
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
                    <div class="card-body">
                        <form action="{{route('regenerate-api-token')}}" method="post">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="">API Token</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">My API Token</label>
                                                <input type="text" class="form-control" value="{{Auth::user()->api_token ?? ''}}" name="apiToken" placeholder="API Token">
                                                @error('apiToken') <i class="text-danger">{{$message}}</i>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right d-flex justify-content-center">
                                    <button type="submit" class="btn btn-custom w-50">Regenerate Another API Token</button>
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
    <script src="/assets/libs/select2/js/select2.min.js"></script>
    <script src="/assets/js/pages/form-advanced.init.js"></script>
    <script>
        $(document).ready(function(){
            $(document).on('keydown','#message', function() {
                var leng = $(this).val();
                $('#character-counter').text(leng.length+1);
            });
            $(document).on('blur','#message', function() {
                var leng = $(this).val();
                $('#character-counter').text(leng.length+1);
            });
        });
    </script>
@endsection
