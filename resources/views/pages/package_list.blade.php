@extends('layer.layout')
@section('main')
<div class='container col-md-6'>
    <h2>Package Lists</h2>
    @if(session('success'))
    <div class='alert alert-success'>
        {{session('success')}}
    </div>
    @endif
    @if(session('update'))
    <div class='alert alert-success'>
        {{session('update')}}
    </div>
    @endif
    @if(session('deleted'))
    <div class='alert alert-success'>
        {{session('deleted')}}
    </div>
    @endif
    <table class="table">
        <thead class='table_head'>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Package Name</th>
                <th scope="col">Package Price</th>
                <th scope="col" colspan='2'>Action</th>
            </tr>
        </thead>
        <tbody class='table_body'>
            @foreach($data as $index=>$rowdata)
            <tr>
                <th scope="row">{{$index+1}}</th>
                <td>{{$rowdata->package_name}}</td>
                <td>{{$rowdata->package_price}}</td>
                <td>
                    <a class='btn btn-info' href="{{route('admin.package_edit',['id'=>$rowdata->id])}}"> Edit</a>
                </td>
                <td>
                    <a class='btn btn-danger' href="{{route('admin.package_delete',['id'=>$rowdata->id])}}"> Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection