@extends('layouts.app')

@section('title', 'Viewing discussion')

@section('content')
    <div class="container">
        {{-- Breadcrumbs removed per Alan --}}
        {{--<ol class="breadcrumb">--}}
            {{--<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('groups.member-dashboard', $group->slug) }}">{{ $group->name }}</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('groups.discussions.index', $group->slug) }}">Discussions</a></li>--}}
            {{--<li class="breadcrumb-item active">Viewing discussion</li>--}}
        {{--</ol>--}}

        <h2 class="mb-3 dmh-modal-topic">{{$discussion->title}} <a class="pull-right" href="{{ route('groups.discussions.index',['group'=>$group->slug]) }}" ><button class="btn btn-primary">Back</button></a></h2>

        <discussion-thread
                :initial-discussion="{{ $discussion->toJson() }}"
                :group="{{ $group->toJson() }}"
                :members="{{ $members->toJson() }}">
        </discussion-thread>
    </div>
@endsection