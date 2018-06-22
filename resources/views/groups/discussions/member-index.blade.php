@extends('layouts.app')

@section('title', 'Private Discussions')

@section('content')
    <div class="container">
        {{-- Breadcrumbs removed per Alan --}}
        {{--<ol class="breadcrumb">--}}
            {{--<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('groups.member-dashboard', $group->slug) }}">{{ $group->name }}</a></li>--}}
            {{--<li class="breadcrumb-item active">Private Discussions: {{ $member->user->name }}</li>--}}
        {{--</ol>--}}
        <h1 class="mb-3">Private Discussions <small>To: {{ $member->user->name }}</small></h1>

        <div class="row">
            <div class="col">
                @if($discussions->isEmpty())
                    <div class="d-flex mb-3">
                        <div class="ml-auto">
                            <a href="{{ route('members.discussions.create', [$member->id]) }}" class="btn btn-secondary">
                                <i class="fa fa-plus" aria-hidden="true"></i> new private discussion
                            </a>
                        </div>
                    </div>
                @endif
                @include('groups.discussions._discussions_list')
            </div>
            <div class="col-md-4 order-md-first">
                @include('groups.discussions._discussions_menu')
            </div>
        </div>
    </div>
@endsection