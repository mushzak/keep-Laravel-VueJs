@extends('layouts.app')

@section('title', "Edit meeting")

@section('content')
    <div class="container">
        <h1>Edit meeting</h1>

        <edit-meeting-form
                action="{{ route('groups.meetings.update', [$group->slug, $meeting->id]) }}"
                :meeting="{{ $meeting->toJson() }}"
                :members="{{ $members->toJson() }}">
        </edit-meeting-form>
    </div>
@endsection