
@extends('layouts.master-layout')
@section('current-page')
    <small>Automations</small>
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
                        @include('followup.partial._top-navigation')
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('marketing-create-automation')}}"  class="btn btn-primary"> Create Automation <i class="bx bxs-send"></i> </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-header">
                                        Automations
                                    </div>
                                    <div class="table-responsive mt-3">
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th class="">#</th>
                                                <th class="wd-15p">Date</th>
                                                <th class="wd-15p">Title</th>
                                                <th class="wd-15p">Triggers on...</th>
                                                <th class="wd-15p">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $index = 1; @endphp
                                            @foreach($automations as $automate)
                                                <tr>
                                                    <td>{{$index++}}</td>
                                                    <td>{{date('d M, Y', strtotime($automate->created_at))}}</td>
                                                    <td>{{$automate->title ?? '' }}</td>
                                                    <td>
                                                        @switch($automate->trigger_action)
                                                            @case(1)
                                                            Member Sign-up
                                                            @break
                                                            @case(2)
                                                            Visitor Sign-up
                                                            @break
                                                            @case(3)
                                                            New Lead
                                                            @break
                                                            @case(4)
                                                            Membership Start
                                                            @break
                                                            @case(5)
                                                            Promotion
                                                            @break
                                                            @case(6)
                                                            Absence
                                                            @break
                                                            @case(7)
                                                            Member Frozen
                                                            @break
                                                            @case(8)
                                                            Member Cancelled
                                                            @break
                                                            @case(9)
                                                            Manually Triggered
                                                            @break
                                                        @endswitch
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-warning btn-sm" href="{{route('edit-marketing-automation', ['slug'=>$automate->slug])}}"> <i class="bx bx-pencil"></i> Edit</a>
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
