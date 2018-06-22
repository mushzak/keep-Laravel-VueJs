@extends('layouts.app')

@section('title', "Create meeting")

@section('content')
    <div class="container">
        <h1>Schedule a meeting</h1>
        <create-meeting-form
                action="{{ route('groups.meetings.store', [$group->slug]) }}"
                :members="{{ $members->toJson() }}">
        </create-meeting-form>
    </div>
@endsection