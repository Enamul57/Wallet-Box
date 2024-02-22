@extends('layer.layout')
@section('main')
<div class='container col-md-12'>
    <h2>User Details</h2>

   <!-- resources/views/your_view.blade.php -->
<table class='col-md-10' >
    <thead>
        <tr style='border:1px solid black'>
            <th>User ID</th>
            <th>Bank Account</th>
            <th>Card </th>
            <th>Phone</th>
            <th>Contact</th>
            @if(auth()->user()->user_package_name =='higher package'  || auth()->user()->user_package_name == "Higher Package" )
            <th>NID</th>
            <th>Passport</th>
            @endif
            <!-- Add more columns as needed -->
        </tr>
    </thead>
    <tbody>
       
            
                <tr style='border:1px solid black'>
                    <td>{{ $data['user_id'] }}</td>
                    <td>{{ $data['bank_account'] }}</td>
                    <td>{{ $data['card_no'] }}</td>
                    <td>{{ $data['phone'] }}</td>
                    <td>{{ $data['contact'] }}</td>
                    @if(auth()->user()->user_package_name =='higher package'  || auth()->user()->user_package_name == "Higher Package" )
                    <td><img src="{{asset($data['nid'])}}" alt="" style='width:50px;height:50px;'></td>
                    <td><img src="{{asset($data['passport'])}}" alt="" style='width:50px;height:50px;'></td>
                    @endif
                    <!-- Add more cells as needed -->
                </tr>
          
       
    </tbody>
</table>

</div>
@endsection