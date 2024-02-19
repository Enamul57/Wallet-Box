@extends('layer.layout')
@section('main')
    <div class='container'>
        <h2>User Approval List</h2>
        @if (session('approved'))
            <div class="alert alert-success">
                {{session('approved')}}
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Approve</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td><span class='spanClass'>{{ $user->name }}</span></td>
                        <td>
                            <form method="POST" action="{{ route('user.approve', ['id' => $user->id]) }}">
                                @csrf
                                <button type="submit" class='btn btn-success'><i class='fa fa-check'></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
