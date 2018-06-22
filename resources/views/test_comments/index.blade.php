@extends('layouts.app')

@section('content')


    <div class="m-1 col-xs-12">
        <div class="row">

            @foreach($comments as $comment)
                <div class="col-sm-4">
                    <div class="card @if($comment->status=="Open") card-primary @else card-info @endif">
                        <div class="card-heading">{{$comment->id}} - {{$comment->status}}</div>
                        <form action="/tests/{{$comment->id}}" method="POST">
                            <li class="list-group-item">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="comment_uri" value="{{$comment->uri}}">
                                <div class=""><b>Source: </b> {{$comment->user->name}}</div>
                                <div class=""><a href="{{$comment->uri}}">{{$comment->uri}}</a></div>
                                <b>Comment: </b>
                                <textarea rows=10 
                                            name="comment"
                                            class="form-control" 
                                            @if($comment->status=="Closed") disabled @endif>{{$comment->comment}}</textarea>
                                
                                <b>Response:</b>
                                <textarea rows=5 
                                            name="response" 
                                            class="form-control" 
                                            @if($comment->status=="Closed") disabled @endif>{{$comment->response}}</textarea>
                                            
                                <div class=""><b>Created Time: </b>{{$comment->created_at}}</div>
                                <div class=""><b>Updated Time: </b>{{$comment->updated_at}}</div>
                                <select name="status" class="form-control" @if($comment->status=="Closed") disabled @endif>
                                    <option value="Open" @if($comment->status=="Open") selected @endif > Open</option>
                                    <option value="Closed" @if($comment->status=="Closed") selected @endif > Closed</option>
                                </select>
                                <BR>
                                @if($comment->status<>"Closed") <button type="submit" class="btn btn-primary">Save</button> @else @endif

                            </li>
                        </form>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

@endsection