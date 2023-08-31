@extends('layouts.master-layout')
@section('current-page')
    Your Registered Sender IDs
@endsection
@section('extra-styles')

@endsection
@section('breadcrumb-action-btn')
    Your Registered Sender IDs
@endsection

@section('main-content')
    @if(session()->has('success'))
        <div class="row" role="alert">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-all me-2"></i>

                            {!! session()->get('success') !!}

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="wd-15p">Date</th>
                                <th class="wd-15p">Sender ID</th>
                                <th class="wd-15p">Status</th>
                                <th class="wd-15p">Use Case</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $serial = 1; @endphp
                            @foreach(Auth::user()->getUserSenderIds as $sender)
                                <tr>
                                    <td>{{$serial++}}</td>
                                    <td>{{date('d M, Y', strtotime($sender->created_at))}}</td>
                                    <td>{{ strtoupper($sender->sender_id)  }}</td>
                                    <td>{!! $sender->status == 0 ? "<label class='text-warning'>Pending</label>" : "<label class='text-success'>Approved</label>" !!}</td>
                                    <td class="text-right">{{$sender->purpose ?? '' }}</td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                    <div class="form-group d-flex justify-content-center">
                        <a class="btn btn-custom" href="{{route('create-senders')}}">Register Another Sender ID</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('extra-scripts')



@endsection
