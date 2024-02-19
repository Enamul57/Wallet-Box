@extends('layer.layout')
@section('main')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        @if(auth()->user()->role == 1)
        <h1 class="h3 mb-0 text-gray-800">Admin Dashboard</h1>
        @endif
        @if(auth()->user()->role == 0)
        <h1 class="h3 mb-0 text-gray-800">User Dashboard</h1>
        @endif

    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->

        <!-- Earnings (Monthly) Card Example -->

        <!-- Earnings (Monthly) Card Example -->


        <!-- Pending Requests Card Example -->

    </div>

    <!-- Content Row -->



    <!-- Content Row -->


</div>
@endsection
