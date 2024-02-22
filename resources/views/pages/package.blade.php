@extends('layer.layout')
@section('main')
<div class='container col-md-6'>
    <h2>Package Management</h2>

    <form method='POST' action="{{route('admin.package_post')}}">
        @csrf
        <div class="mb-3">
            <label  class="form-label label_class">Package Name</label>
            <input type="text" class="form-control"  name='package_name' >
        </div>
        <div class="mb-3">
            <label  class="form-label label_class">Package Price (TK)</label>
            <input type="number" class="form-control" id="exampleInputPassword1" name='package_price' >
        </div>
        
        <button type="submit" class="btn btn-primary">Submit</button>
        @if($errors->has('error'))
        <div class='alert alert-danger'>
            {{$errors->first('error')}}
        </div>
         @endif
         @if(session('success'))
        <div class='alert alert-success'>
            {{session('success')}}
        </div>
         @endif
    </form>
</div>
@endsection