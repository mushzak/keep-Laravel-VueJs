@extends('layouts.app')

@section('title', 'Create Group Discussion')

@section('content')
    <div class="container">
        {{-- Breadcrumbs removed per Alan --}}
        {{--<ol class="breadcrumb">--}}
            {{--<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('groups.member-dashboard', $group->slug) }}">{{ $group->name }}</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('groups.discussions.index', $group->slug) }}">Group Discussions</a></li>--}}
            {{--<li class="breadcrumb-item active">Create Group Discussion</li>--}}
        {{--</ol>--}}

        <h1 class="mb-3">Create Group Discussion</h1>

        <create-discussion-form
                action="{{ route('groups.discussions.store', $group->slug) }}">
        </create-discussion-form>
    </div>
@endsection