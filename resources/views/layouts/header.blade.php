<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>SERVICE PREMIUM </title>
        {{-- <link rel="apple-touch-icon" href="{{ asset('loader/logo.jpg') }}"> --}}
        <link rel="icon" href="{{ asset('loader/logo.png') }}" type="image/png">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css')}}">
        <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css')}}">
        <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css')}}">
        <link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css')}}">
        <link rel="stylesheet" href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css')}}">
        <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
        <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
        <link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
        <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css')}}">

        <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <a href="/" class="logo">
                    <span class="logo-mini"><b>..</b></span>
                    <span class="logo-lg"><b>SERVICE PREMIUM</b></span>
                </a>
                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                </nav>
            </header>
            <aside class="main-sidebar">
                <section class="sidebar">
                  <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN MENUS</li>
                        <li class=" {{ isActiveRoute('home') }}"><a href="/"><i class="fa fa-home"></i> <span>Home</span></a></li>
                        <li class=" {{ isActiveRoute('addresult') }}"><a href="/addresult"><i class="fa fa-plus"></i> <span>Publish New Result</span></a></li>
                        <li class=" {{ isActiveRoute('published_result') }}"><a href="/published_result"><i class="fa fa-graduation-cap"></i> <span>Published Results</span></a></li>
                        <li class=" {{ isActiveRoute('club_result') }}"><a href="/club_result"><i class="fa fa-graduation-cap"></i> <span>Club Vise Marks</span></a></li>
                        {{-- <li class="treeview">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Documents</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ asset('Files/1.pdf') }}"><i class="fa fa-circle-o"></i> General Details</a></li>
                                <li><a href="{{ asset('Files/2.pdf') }}"><i class="fa fa-circle-o"></i> Arts Items Details</a></li>
                                <li><a href="{{ asset('Files/3.pdf') }}"><i class="fa fa-circle-o"></i> Sports Item Details</a></li>
                            </ul>
                        </li> --}}
                        @guest
                        @else
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();"><i class="fa fa-book"></i>
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                        @endguest

                  </ul>
                </section>
            </aside>
            <div class="content-wrapper">