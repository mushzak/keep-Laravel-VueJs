@extends('layouts/app')

@section('content')
    <div class="container">
        <h1>User</h1>

        <form method="POST" action="/User/{{$data->id}}">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="row">
                <div class="form-group ">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{$data->name}}" required>
                </div>
                <div class="form-group ">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" value="{{$data->email}}" required>
                </div>

                <div class="form-group ">
                    <label>Company</label>
                    <input type="text" name="business" class="form-control" value="{{$data->business}}" required>
                </div>

                <div class="form-group ">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{$data->phone}}" required>
                </div>

                <div class="form-group ">
                    <label>Text</label>
                    <input type="text" name="text_phone" class="form-control" value="{{$data->text_phone}}" required>
                </div>

                <div class="form-group ">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" value="{{$data->email}}" required>
                </div>

            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
@stop