
@extends('layouts.master-layout')
@section('current-page')
    Follow-up Dashboard
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
                            <div class="row mt-5">
                                <div class="col-md-12 col-xxl-12 col-sm-12">
                                    <p>Currently showing performance report for @if($search == 0)<code>{{date('Y')}}</code> @else
                                            <span><strong class="text-success">From:</strong> {{date('d M, Y', strtotime($from))}}</span>
                                            <span><strong class="text-danger">To:</strong> {{date('d M, Y', strtotime($to))}}</span>
                                        @endif</p>
                                </div>
                                <div class="col-xxl-4 col-md-4 col-sm-4">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">Select</div>
                                        <div class="card-header m-4">
                                            <form action="{{route('marketing-dashboard-filter')}}" class="" method="get">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="" class="text-muted">Filter</label>
                                                    <select name="filterType" id="filterType" class="form-control">
                                                        <option value="1">All</option>
                                                        <option value="2">Date Range</option>
                                                    </select>
                                                    @error('filterType') <i class="text-danger">{{$message}}</i> @enderror
                                                </div>
                                                <div class="form-group mt-3 dateInputs">
                                                    <label for="" class="text-success">From</label>
                                                    <input type="date" class="form-control" name="from">
                                                    @error('from') <i class="text-danger">{{$message}}</i> @enderror
                                                </div>
                                                <div class="form-group mt-3 dateInputs">
                                                    <label for="" class="text-danger">To</label>
                                                    <input type="date" class="form-control" name="to">
                                                    @error('to') <i class="text-danger">{{$message}}</i> @enderror
                                                </div>
                                                <div class="mt-3 form-group d-flex justify-content-center">
                                                    <button class="btn btn-primary btn-sm">Submit <i class="bx bx-filter"></i> </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-8 col-md-8 col-sm-8">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">Performance Chart</div>
                                        <div class="card-body">
                                            <div id="stacked-column-chart" class="apex-charts" dir="ltr"></div>
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
    <script src="/assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="/assets/js/axios.min.js"></script>
    <script>
        const incomeData = [0,0,0,0,0,0,0,0,0,0,0,0];
        const expenseData = [0,0,0,0,0,0,0,0,0,0,0,0];
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const search = "{{$search}}";
        const url = parseInt(search) === 0 ? "{{route('revenue-statistics') }}" : "{{route('revenue-statistics-range')}}";
        $(document).ready(function(){
            $('.dateInputs').hide();
            $('#filterType').on('change', function(e){
                e.preventDefault();
                if($(this).val() == 1){
                    $('.dateInputs').hide();
                }else{
                    $('.dateInputs').show();
                }
            });

            /*Bar chart*/
            axios.get(url)
                .then(res=> {
                    const income = res.data.income;
                    income.map((inc) => {
                        switch (inc.month) {
                            case 1:
                                plotGraph(1, 1, inc.amount);
                                break;
                            case 2:
                                plotGraph(2, 1, inc.amount);
                                break;
                            case 3:
                                plotGraph(3, 1, inc.amount);
                                break;
                            case 4:
                                plotGraph(4, 1, inc.amount);
                                break;
                            case 5:
                                plotGraph(5, 1, inc.amount);
                                break;
                            case 6:
                                plotGraph(6, 1, inc.amount);
                                break;
                            case 7:
                                plotGraph(7, 1, inc.amount);
                                break;
                            case 8:
                                plotGraph(8, 1, inc.amount);
                                break;
                            case 9:
                                plotGraph(9, 1, inc.amount);
                                break;
                            case 10:
                                plotGraph(10, 1, inc.amount);
                                break;
                            case 11:
                                plotGraph(11, 1, inc.amount);
                                break;
                            case 12:
                                plotGraph(12, 1, inc.amount);
                                break;
                        }

                    });
                    //then
                    var options = {
                            chart: { height: 360, type: "bar", stacked: !0, toolbar: { show: !1 }, zoom: { enabled: !0 } },
                            plotOptions: { bar: { horizontal: !1, columnWidth: "15%", endingShape: "rounded" } },
                            dataLabels: { enabled: !1 },
                            series: [
                                { name: "Performance", data: incomeData },
                            ],
                            xaxis: { categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"] },
                            colors: ["#34c38f", "#f1b44c"],
                            legend: { position: "bottom" },
                            fill: { opacity: 1 },
                        },
                        chart = new ApexCharts(document.querySelector("#stacked-column-chart"), options);
                    chart.render();

                });
        });

        function plotGraph(index,type, value){
            if(parseInt(type) === 1){
                incomeData[index-1] = value;
            }
        }
    </script>
@endsection
