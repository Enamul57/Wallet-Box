@extends('layer.layout')
@section('main')
<div class="container">

    <!-- Page Heading -->
    <div class="wallet_dashboard align-items-center justify-content-between mb-4 ">
        @if(auth()->user()->role == 1)
        <h1 class="h3 mb-0 text-gray-800">Admin Dashboard</h1>
        @endif
        @if(auth()->user()->role == 0)
        @if(Auth::user()->user_package_purchase)
        @if(session('purchased'))
        <div class='alert alert-success'>
            <h3>{{session('purchased')}}</h3>
        </div>
        @endif
        <h1 class="h3 mb-0 text-gray-800">User Wallet Dashboard</h1>
        <form class='mt-5 col-md-6' method='POST' action="{{route('profile_details')}}" enctype='multipart/form-data'>
            @csrf
            <div class="mb-3">
                <label class="form-label">Bank Account</label>
                <input type="hidden" class="form-control" id="exampleInputEmail1" name='user_id' value="{{Auth::user()->id}}">
  
                <input type="text" class="form-control" id="exampleInputEmail1" name='bank_account' required>
            </div>
            <div class="mb-3">
                <label class="form-label">Card No</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name='card_no' required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="tel" class="form-control" id="exampleInputEmail1" name='phone' required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contact</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name='contact' required>
            </div>
            @if(Auth::user()->user_package_name=='Higher Package' || Auth::user()->user_package_name=='higher package')
            <div class="mb-3">
                <label class="form-label">Passport</label>
                <input type="file" class="form-control" id="exampleInputEmail1" name='passport' >
            </div>
            <div class="mb-3">
                <label class="form-label">NID</label>
                <input type="file" class="form-control" id="exampleInputEmail1" name='nid'>
            </div>
            @endif
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        @elseif(auth()->user()->user_package_purchase === null || auth()->user()->user_package_purchase==0)

        <div class='container'>
            <h3>Purchase Package</h3>
            <table class="table">
                <thead class='table_head'>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Package Name</th>
                        <th scope="col">Package Price</th>
                        <th scope="col">Purchase</th>
                    </tr>
                </thead>
                <tbody class='table_body'>
                    @foreach($packages as $index=>$package)
                    <tr>
                        <th scope="row">{{$index+1}}</th>
                        <td>{{$package->package_name}}</td>
                        <td>{{$package->package_price}}</td>
                        <td>
                            <form action="{{route('user.checkout')}}" method='POST'>
                                @csrf
                                <input type="hidden" name='user_name' value="{{Auth::user()->name}}">
                                <input type="hidden" name='user_id' value="{{Auth::user()->id}}">
                                <input type="hidden" name='email' value="{{Auth::user()->email}}">
                                <input type="hidden" name='package_name' value="{{$package->package_name}}">
                                <input type="hidden" name='package_price' value="{{$package->package_price}}">
                                <input type="hidden" name='package_role' value="{{$package->package_role}}">
                                <button class='btn btn-primary' type='submit'> Purchase</button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
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