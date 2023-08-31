<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <title>{{config('app.name')}} | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="App description goes here..." name="description" />
    <meta content="{{config('app.name')}}" name="PoweredBy" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{url('storage/'.Auth::user()->getUserOrganization->favicon)}}">
    {{--<link rel="stylesheet" href="{{asset('css/nprogress.css')}}">--}}
    <link href="{{asset('css/parsley.css')}}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    {{--<link href="{{asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />--}}
    {{--<script src="{{ asset('js/app.js') }}" defer></script>--}}
    <style>
        #sidebar-menu ul li a i, body[data-sidebar=dark] #sidebar-menu ul li a{
            color: #ffffff !important;
        }
    </style>

    @yield('extra-styles')

</head>
