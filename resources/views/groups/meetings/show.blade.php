@extends('layouts.app')

@section('title', "Show meeting")

@section('content')
    <div class="ml-2 mr-2">

        <h1>{{ $meeting->subject }}
            <small><a href="{{ route('groups.meetings.index',['group'=>$group->slug]) }}">All Meetings</a></small>
        </h1>

        <meeting-room
                :auth="{{ auth()->user()->toJson() }}"
                :initial-meeting="{{ $meeting->toJson() }}"
                :initial-discussion="{{ $meeting->discussion->toJson() }}"
                :group="{{$meeting->group->toJson()}}"
                :members="{{$meeting->members()->with('group')->get()->toJson()}}"
                :is-facilitator.boolean="{{ auth()->user()->can('facilitate', $group) ? 'true' : 'false' }}"></meeting-room>
    </div>
@endsection

@section('footer')
   {{--  Hide footer for this page only --}}
@endsection