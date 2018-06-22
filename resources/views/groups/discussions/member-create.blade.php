@extends('layouts.app')

@section('title', 'Create Private Discussion')

@section('content')
    <div class="container">
        {{-- Breadcrumbs removed per Alan --}}
        {{--<ol class="breadcrumb">--}}
            {{--<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('groups.member-dashboard', $group->slug) }}">{{ $group->name }}</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('members.discussions.index', $member->id) }}">Private Discussions: {{ $member->user->name }}</a></li>--}}
            {{--<li class="breadcrumb-item active">Create Private Discussion</li>--}}
        {{--</ol>--}}

        <h1 class="mb-3">Create Private Discussion</h1>

        <create-discussion-form
                action="{{ route('members.discussions.store', $member->id) }}">
        </create-discussion-form>
    </div>
@endsection