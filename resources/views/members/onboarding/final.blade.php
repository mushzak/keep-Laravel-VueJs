@extends('layouts.app')

@section('title', 'Complete Action Items')

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
                <H2>Complete Action Items</H2>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-2">
                {{-- Blank spot for spacing --}}
            </div>
            <div class="col-8 border p-3">
                You are almost finished. Please look at the action items for a lsit of items to completed your profile. 
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