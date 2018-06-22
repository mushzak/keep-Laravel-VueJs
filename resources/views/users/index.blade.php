@extends('layouts/app')

@section('content')
    <div class="container">
        <h1 class="mb-3">Users</h1>
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Business</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Text</th>  
                </tr>

                @foreach ($users as $user)
                    <tr>
                        <td><a href="{{ route('Users.edit', $user->id) }}">{$data->name}}</a></td>
                        <td>{{$data->business}}</td>
                        <td>{{$data->email}}</td>
                        <td>{{$data->phone}}</td>
                        <td>{{$data->text_phone}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
