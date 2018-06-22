@extends('layouts.app')

@section('content')


    <div class="col-md-8">
        <div class="card card-primary">

            <div class="card-heading">New Comment</div>
            <form action="/tests" method="POST">
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="comment_uri" value="{{$comment_uri}}">

                <li class="list-group-item">
                    <div><b>Page: </b><a href="/{{$comment_uri}}" >{{$comment_uri}}</a></div>
                    <div><b>User: </b> {{Auth::user()->name}}</div>
                    <div><textarea rows=10 name="comment" class="form-control" placeholder="Required: Enter Details Here" Required></textarea></div>
                    <div>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </li>
            </form>

        </div>

    </div>

@endsection