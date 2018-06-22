@extends('layouts.app')

@section('title', "Edit agenda item")

@section('content')
    <div class="container">
        {{-- Breadcrumbs removed per Alan --}}
        {{--<ol class="breadcrumb">--}}
            {{--<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('groups.member-dashboard', $group->slug) }}">{{ $group->name }}</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('groups.meetings.index', $group->slug) }}">Meetings</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('groups.meetings.show', [$group->slug, $meeting->id]) }}">{{ $meeting->subject }}</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('meetings.agendas.index', [$meeting->id]) }}">Agenda items</a></li>--}}
            {{--<li class="breadcrumb-item active">Edit agenda item</li>--}}
        {{--</ol>--}}

        <h1>Edit agenda item</h1>

        <edit-meeting-agenda-form
                :meeting="{{ $meeting->toJson() }}"
                :agenda="{{ $agenda->toJson() }}">
        </edit-meeting-agenda-form>
    </div>
@endsection