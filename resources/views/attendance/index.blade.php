@extends('layouts.master-layout')
@section('current-page')
    Attendance
@endsection
@section('extra-styles')
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <link href="/css/parsley.css" rel="stylesheet" type="text/css" />
    <style>

    </style>
    <link href="/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
@endsection
@section('breadcrumb-action-btn')

@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-md-12">
                @if(session()->has('success'))
                    <div class="row" role="alert">
                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-check-all me-2"></i>
                                {!! session()->get('success') !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                @endif
                @if($errors->any())
                    <div class="row" role="alert">
                        <div class="col-md-12">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-check-all me-2"></i>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#takeAttendance" class="btn btn-primary  mb-3">Take Attendance <i class="bx bx bx-highlight"></i> </a>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title"> Attendance</h4>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Chart View</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">List View</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="row mt-3">
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-1">
                                                    <div class="col">
                                                        <p class="mb-2 text-dark font-size-18">Last Year</p>
                                                        <h3 class="mb-0 number-font">{{number_format( $lastYear->sum('a_no_men') + $lastYear->sum('a_no_women') + $lastYear->sum('a_no_children') )}}</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-1">
                                                    <div class="col">
                                                        <p class="mb-2 text-primary font-size-18">This Year</p>
                                                        <h3 class="mb-0 number-font">{{number_format( $attendance->sum('a_no_men') + $attendance->sum('a_no_women') + $attendance->sum('a_no_children') )}}</h3>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-1">
                                                    <div class="col">
                                                        <p class="mb-2 font-size-18 text-info">Last Month</p>
                                                        <h3 class="mb-0 number-font">{{number_format( $lastMonth->sum('a_no_men') + $lastMonth->sum('a_no_women') + $lastMonth->sum('a_no_children') )}}</h3>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-1">
                                                    <div class="col">
                                                        <p class="mb-2 text-success font-size-18">This Month</p>
                                                        <h3 class="mb-0 number-font">{{number_format( $currentMonth->sum('a_no_men') + $currentMonth->sum('a_no_women') + $currentMonth->sum('a_no_children') )}}</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab panes -->
                                <div class="tab-content p-3 text-muted">
                                    <div class="tab-pane active" id="home1" role="tabpanel">
                                        <div class="card-body">
                                            <div id="attendanceMedication" class="apex-charts" dir="ltr"></div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="profile1" role="tabpanel">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-12">
                                                    <div class="table-responsive mt-3">
                                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                                            <thead>
                                                            <tr>
                                                                <th class="">#</th>
                                                                <th class="wd-15p">Date</th>
                                                                <th class="wd-15p">Program</th>
                                                                <th class="wd-15p">Taken By</th>
                                                                <th class="wd-15p">Men</th>
                                                                <th class="wd-15p">Women</th>
                                                                <th class="wd-15p">Children</th>
                                                                <th class="wd-15p">Total</th>
                                                                <th class="wd-15p">Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php $index = 1; @endphp
                                                            @foreach($attendance as $attend)
                                                                <tr>
                                                                    <td>{{$index++}}</td>
                                                                    <td>{{date('d M, Y', strtotime($attend->a_program_date))}}</td>
                                                                    <td>{{$attend->a_program_name ?? '' }} </td>
                                                                    <td>{{$attend->getTakenBy->first_name ?? '' }} {{$attend->getTakenBy->last_name ?? '' }}</td>
                                                                    <td>{{number_format($attend->a_no_men ?? 0)}}</td>
                                                                    <td>{{number_format($attend->a_no_women ?? 0)}}</td>
                                                                    <td>{{number_format($attend->a_no_children ?? 0)}}</td>
                                                                    <td>{{number_format(($attend->a_no_children + $attend->a_no_men + $attend->a_no_women) ?? 0)}}</td>
                                                                    <td>
                                                                        <div class="btn-group">
                                                                            <i class="bx bx-dots-vertical dropdown-toggle text-warning" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                                                                            <div class="dropdown-menu">
                                                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-target="#attendanceModal_{{$attend->a_id}}" data-bs-toggle="modal"> <i class="text-warning bx bx-pencil"></i> Edit</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal right fade" id="attendanceModal_{{$attend->a_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" style="width: 900px;">
                                                                            <div class="modal-dialog " role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header" >
                                                                                        <h6 class="modal-title text-uppercase" style="text-align: center;" id="myModalLabel2">Edit Attendance</h6>
                                                                                        <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>

                                                                                    <div class="modal-body">
                                                                                        <form autocomplete="off" action="{{route('edit-attendance')}}" id="createIncomeForm" data-parsley-validate="" method="post" enctype="multipart/form-data">
                                                                                            @csrf
                                                                                            <div class="row mb-3">
                                                                                                <div class="form-group mt-1 col-md-12">
                                                                                                    <label for=""> Program Name <sup class="text-danger">*</sup></label>
                                                                                                    <input type="text" placeholder="Program Name" name="programName" value="{{ old('programName', $attend->a_program_name) }}" class="form-control">
                                                                                                    @error('programName') <i class="text-danger">{{$message}}</i>@enderror
                                                                                                </div>
                                                                                                <div class="form-group mt-1 col-md-12 ">
                                                                                                    <label for="">Date <span class="text-danger">*</span></label>
                                                                                                    <input type="date" value="{{date('Y-m-d', strtotime($attend->a_program_date))}}" name="programDate" class="form-control">
                                                                                                    @error('programDate') <i class="text-danger">{{$message}}</i>@enderror
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row mb-3">
                                                                                                <div class="form-group mt-1 col-md-12">
                                                                                                    <label for=""> No. of Men<small class="">(Optional)</small></label>
                                                                                                    <input type="number" placeholder="Enter Number of Men" value="{{old('men',$attend->a_no_men)}}" name="men" class="form-control">
                                                                                                    @error('men') <i class="text-danger">{{$message}}</i>@enderror
                                                                                                </div>
                                                                                                <div class="form-group mt-1 col-md-12">
                                                                                                    <label for=""> No. of Women<small class="">(Optional)</small></label>
                                                                                                    <input type="number" placeholder="Enter Number of Women" value="{{old('women',$attend->a_no_women)}}" name="women" class="form-control">
                                                                                                    @error('women') <i class="text-danger">{{$message}}</i>@enderror
                                                                                                </div>
                                                                                                <div class="form-group mt-1 col-md-12">
                                                                                                    <label for=""> No. of Children<small class="">(Optional)</small></label>
                                                                                                    <input type="number" placeholder="Enter Number of Children" value="{{old('children',$attend->a_no_children)}}" name="children" class="form-control">
                                                                                                    @error('children') <i class="text-danger">{{$message}}</i>@enderror
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row mb-3">
                                                                                                <div class="form-group mt-1 col-md-12">
                                                                                                    <label for="">Narration</label> <br>
                                                                                                    <textarea name="narration" id="narration" style="resize: none;" placeholder="Type narration here..." class="form-control">{{old('narration', $attend->a_narration)}}</textarea>
                                                                                                    @error('narration') <i class="text-danger">{{$message}}</i>@enderror
                                                                                                    <input type="hidden" name="attendanceId" value="{{ $attend->a_id }}">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group d-flex justify-content-center mt-3">
                                                                                                <div class="btn-group">
                                                                                                    <button type="submit" class="btn btn-primary  waves-effect waves-light">Save changes <i class="bx bxs-right-arrow"></i> </button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>

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
                </div>
            </div>
        </div>
    </div>

    <div class="modal right fade" id="takeAttendance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" style="width: 900px;">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <h6 class="modal-title text-uppercase" style="text-align: center;" id="myModalLabel2">Take Attendance</h6>
                    <button type="button" style="margin: 0px; padding: 0px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form autocomplete="off" action="{{route('attendance')}}" id="createIncomeForm" data-parsley-validate="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="form-group mt-1 col-md-12">
                                <label for=""> Program Name <sup class="text-danger">*</sup></label>
                                <input type="text" placeholder="Program Name" name="programName" value="{{ old('programName') }}" class="form-control">
                                @error('programName') <i class="text-danger">{{$message}}</i>@enderror
                            </div>
                            <div class="form-group mt-1 col-md-12 ">
                                <label for="">Date <span class="text-danger">*</span></label>
                                <input type="date" value="{{date('Y-m-d')}}" name="programDate" class="form-control">
                                @error('programDate') <i class="text-danger">{{$message}}</i>@enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group mt-1 col-md-12">
                                <label for=""> No. of Men<small class="">(Optional)</small></label>
                                <input type="number" placeholder="Enter Number of Men" value="{{old('men',0)}}" name="men" class="form-control">
                                @error('men') <i class="text-danger">{{$message}}</i>@enderror
                            </div>
                            <div class="form-group mt-1 col-md-12">
                                <label for=""> No. of Women<small class="">(Optional)</small></label>
                                <input type="number" placeholder="Enter Number of Women" value="{{old('women',0)}}" name="women" class="form-control">
                                @error('women') <i class="text-danger">{{$message}}</i>@enderror
                            </div>
                            <div class="form-group mt-1 col-md-12">
                                <label for=""> No. of Children<small class="">(Optional)</small></label>
                                <input type="number" placeholder="Enter Number of Children" value="{{old('children',0)}}" name="children" class="form-control">
                                @error('children') <i class="text-danger">{{$message}}</i>@enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group mt-1 col-md-12">
                                <label for="">Narration</label> <br>
                                <textarea name="narration" id="narration" style="resize: none;" placeholder="Type narration here..." class="form-control">{{old('narration')}}</textarea>
                                @error('narration') <i class="text-danger">{{$message}}</i>@enderror
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-center mt-3">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary  waves-effect waves-light">Submit Attendance <i class="bx bxs-right-arrow"></i> </button>
                            </div>
                        </div>
                    </form>

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
    <script src="/assets/js/pages/datatables.init.js"></script>

    <script src="/assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="/vectormap/jquery-jvectormap-in-mill.js"></script>
    <script src="/vectormap/jquery-jvectormap-us-aea-en.js"></script>
    <script src="/vectormap/jquery-jvectormap-uk-mill-en.js"></script>
    <script src="/vectormap/jquery-jvectormap-au-mill.js"></script>
    <script src="/assets/js/axios.min.js"></script>

    <script src="/js/chart.js"></script>
    <script>
        const menData = [0,0,0,0,0,0,0,0,0,0,0,0];
        const womenData = [0,0,0,0,0,0,0,0,0,0,0,0];
        const childrenData = [0,0,0,0,0,0,0,0,0,0,0,0];
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $(document).ready(function(){

            /*Attendance: Men vs Women vs Children*/
            const url = "{{route('chart-attendance') }}";
            axios.get(url)
                .then(res=> {
                    const men = res.data.men;
                    const women = res.data.women;
                    const children = res.data.children;
                   //Men
                    men.map((m) => {
                        switch (m.month) {
                            case 1:
                                plotAttendanceMedicationGraph(1, 1, m.total);
                                break;
                            case 2:
                                plotAttendanceMedicationGraph(2, 1, m.total);
                                break;
                            case 3:
                                plotAttendanceMedicationGraph(3, 1, m.total);
                                break;
                            case 4:
                                plotAttendanceMedicationGraph(4, 1, m.total);
                                break;
                            case 5:
                                plotAttendanceMedicationGraph(5, 1, m.total);
                                break;
                            case 6:
                                plotAttendanceMedicationGraph(6, 1, m.total);
                                break;
                            case 7:
                                plotAttendanceMedicationGraph(7, 1, m.total);
                                break;
                            case 8:
                                plotAttendanceMedicationGraph(8, 1, m.total);
                                break;
                            case 9:
                                plotAttendanceMedicationGraph(9, 1, m.total);
                                break;
                            case 10:
                                plotAttendanceMedicationGraph(10, 1, m.total);
                                break;
                            case 11:
                                plotAttendanceMedicationGraph(11, 1, m.total);
                                break;
                            case 12:
                                plotAttendanceMedicationGraph(12, 1, m.total);
                                break;
                        }

                    });
                    //Women
                    women.map((w) => {
                        switch (w.month) {
                            case 1:
                                plotAttendanceMedicationGraph(1, 2, w.total);
                                break;
                            case 2:
                                plotAttendanceMedicationGraph(2, 2, w.total);
                                break;
                            case 3:
                                plotAttendanceMedicationGraph(3, 2, w.total);
                                break;
                            case 4:
                                plotAttendanceMedicationGraph(4, 2, w.total);
                                break;
                            case 5:
                                plotAttendanceMedicationGraph(5, 2, w.total);
                                break;
                            case 6:
                                plotAttendanceMedicationGraph(6, 2, w.total);
                                break;
                            case 7:
                                plotAttendanceMedicationGraph(7, 2, w.total);
                                break;
                            case 8:
                                plotAttendanceMedicationGraph(8, 2, w.total);
                                break;
                            case 9:
                                plotAttendanceMedicationGraph(9, 2, w.total);
                                break;
                            case 10:
                                plotAttendanceMedicationGraph(10, 2, w.total);
                                break;
                            case 11:
                                plotAttendanceMedicationGraph(11, 2, w.total);
                                break;
                            case 12:
                                plotAttendanceMedicationGraph(12, 2, w.total);
                                break;
                        }

                    });
                    //Children
                    children.map((c) => {
                        switch (c.month) {
                            case 1:
                                plotAttendanceMedicationGraph(1, 3, c.total);
                                break;
                            case 2:
                                plotAttendanceMedicationGraph(2, 3, c.total);
                                break;
                            case 3:
                                plotAttendanceMedicationGraph(3, 3, c.total);
                                break;
                            case 4:
                                plotAttendanceMedicationGraph(4, 3, c.total);
                                break;
                            case 5:
                                plotAttendanceMedicationGraph(5, 3, c.total);
                                break;
                            case 6:
                                plotAttendanceMedicationGraph(6, 3, c.total);
                                break;
                            case 7:
                                plotAttendanceMedicationGraph(7, 3, c.total);
                                break;
                            case 8:
                                plotAttendanceMedicationGraph(8, 3, c.total);
                                break;
                            case 9:
                                plotAttendanceMedicationGraph(9, 3, c.total);
                                break;
                            case 10:
                                plotAttendanceMedicationGraph(10, 3, c.total);
                                break;
                            case 11:
                                plotAttendanceMedicationGraph(11, 3, c.total);
                                break;
                            case 12:
                                plotAttendanceMedicationGraph(12, 3, c.total);
                                break;
                        }

                    });
                    //then
                    const options2 = {
                            chart: { height: 360, type: "bar", toolbar: { show: !1 }, zoom: { enabled: !0 } },
                            plotOptions: { bar: { horizontal: false, columnWidth: "55%", endingShape: "rounded" } },
                            dataLabels: { enabled: !1 },
                            stroke: {
                                show: true,
                                width: 2,
                                colors: ['transparent']
                            },
                            series: [
                                { name: "Men", data: menData },
                                { name: "Women", data: womenData },
                                { name: "Children", data: childrenData },
                            ],
                            xaxis: { categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"] },
                            yaxis: {
                                title: {
                                    text: 'Attendance'
                                }
                            },
                            tooltip: {
                                y: {
                                    formatter: function (val) {
                                        return val.toLocaleString()
                                    }
                                }
                            },
                            colors: ["#0071C1", "#FE3A6B", '#EBBC1A'],
                            legend: { position: "bottom" },
                            fill: { opacity: 1 },
                        },
                        chart = new ApexCharts(document.querySelector("#attendanceMedication"), options2);
                    chart.render();

                });
        });

        function plotGraph(index,type, value){
            if(parseInt(type) === 1){
                incomeData[index-1] = value;
            }
        }
        function plotAttendanceMedicationGraph(index,type, value){
            if(parseInt(type) === 1){
                menData[index-1] = value;
            }else if(parseInt(type) === 2){
                womenData[index-1] = value;
            }else{
                childrenData[index-1] = value;
            }
        }
    </script>
@endsection
