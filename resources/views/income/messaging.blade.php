
@extends('layouts.master-layout')
@section('current-page')
     <small>Marketing > Messaging</small>
@endsection
@section('extra-styles')
    <link rel="stylesheet" href="/css/nprogress.css">
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

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
                        @include('income.partial._top-navigation')
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('marketing-compose-messaging')}}"  class="btn btn-primary"> Compose Message <i class="bx bxs-envelope"></i> </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-header">
                                         Messages
                                    </div>
                                    <div class="table-responsive mt-3">
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th class="">#</th>
                                                <th class="wd-15p">Date</th>
                                                <th class="wd-15p">Subject</th>
                                                <th class="wd-15p">Excerpt</th>
                                                <th class="wd-15p">Recipients</th>
                                                <th class="wd-15p">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $index = 1; @endphp
                                            @foreach($messages as $message)
                                                <tr>
                                                    <td>{{$index++}}</td>
                                                    <td>{{date('d M, Y h:ia', strtotime($message->created_at))}}</td>
                                                    <td>{{$message->title ?? '' }}</td>
                                                    <td>{{ strlen(strip_tags($message->content)) > 50 ? substr(strip_tags($message->content),0,50).'...' : strip_tags($message->content) }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <span class="badge rounded-pill bg-danger ">{{number_format(count(json_decode($message->sent_to)))}}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary" data-bs-target="#messageDetail_{{$message->id}}" data-bs-toggle="modal">View</button>
                                                        <div class="modal right fade" id="messageDetail_{{$message->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
                                                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header" >
                                                                        <h4 class="modal-title" id="myModalLabel2">Message Details</h4>
                                                                        <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>

                                                                    <div class="modal-body text-wrap">
                                                                        <h5 class="font-size-15 mt-4">{{$message->title ?? '' }}</h5>
                                                                        {!! $message->content ?? ''  !!}
                                                                        <div class="text-muted mt-4 bg-light p-2">
                                                                            <h6 class="font-size-12 mt-4">Sent to...</h6>
                                                                            @foreach($message->getReceivers(json_decode($message->sent_to))  as $re)
                                                                                <p><i class="mdi mdi-chevron-right text-primary me-1"></i>
                                                                                    {{$re->first_name ?? '' }} {{$re->last_name ?? '' }}
                                                                                </p>
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="mt-4">
                                                                            <h6 class="font-size-12 mt-4">Date & Time</h6>
                                                                            <p class="text-muted mb-0">{{date('d M, Y h:ia', strtotime($message->created_at))}}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
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
    <script src="/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script src="/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <!-- Datatable init js -->
    <script src="/assets/js/pages/datatables.init.js"></script>
@endsection
