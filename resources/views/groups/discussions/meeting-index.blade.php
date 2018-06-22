@extends('layouts.app')

@section('title', 'Meeting Discussions')

@section('content')
    <div class="container">
        {{-- Breadcrumbs removed per Alan --}}
        {{--<ol class="breadcrumb">--}}
            {{--<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('groups.member-dashboard', $group->slug) }}">{{ $group->name }}</a></li>--}}
            {{--<li class="breadcrumb-item active">Meeting Discussions</li>--}}
        {{--</ol>--}}

        <h1 class="mb-3">Meeting Discussions</h1>

        <div class="row">
            <div class="col">
                @include('groups.discussions._discussions_list')
            </div>
            <div class="col-md-4 order-md-first">
                @include('groups.discussions._discussions_menu')
            </div>
        </div>
    </div>
@endsection