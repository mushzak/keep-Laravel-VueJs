@extends('layouts.app')

@section('title', 'New Group Member Registration')

@section('content')
    <div class="container">
        {{-- Breadcrumbs removed per Alan --}}
        {{--<ol class="breadcrumb">--}}
            {{--<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('groups.member-dashboard', $group->slug) }}">{{ $group->name }}</a></li>--}}
            {{--<li class="breadcrumb-item active">Analytics</li>--}}
        {{--</ol>--}}
        <div class="mb-4 row">
            <div class="mx-auto">
                <H2>Welcome</H2>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-2">
                {{-- Blank spot for spacing --}}
            </div>
            <div class="col-8 border p-3">
                Welcome to the {{$member->group->name}} group. Feel free to explore your dashboard at any time. To access Member Profiles and Discussions, we will need for you to complete your Action Items. Would you like to start on that that now?
            </div>

            <div class="col-2 col-2  text-right">
                <a href="{{ url("members/$member->id/onboarding/".($step+1)) }}" ><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="row mt-4">
            <div class="mx-auto">
                <i class="fa fa-circle-o mr-1" aria-hidden="true"></i><i class="fa fa-circle mr-1" aria-hidden="true"></i><i class="fa fa-circle mr-1" aria-hidden="true"></i><i class="fa fa-circle mr-1" aria-hidden="true"></i><i class="fa fa-circle mr-1" aria-hidden="true"></i> 

            </div>
        </div>

           



    </div>
@endsection