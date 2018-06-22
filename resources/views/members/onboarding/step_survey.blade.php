@extends('layouts.app')

@section('title', 'Expectation Survey')

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
                <H2>Expectation Survey</H2>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-2">
                <a href="{{ url("members/$member->id/onboarding/".($step-1)) }}" ><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a>
            </div>
            <div class="col-8 border p-3">
                <div class="form-group">
                    <label for="q1" class=""> Why did you join this group?</label>
                    <textarea class="form-control" name="q1" id="q1"></textarea>
                </div>
                <div class="form-group">
                    <label for="q2" class=""> What do you expect as an outcome of participating in this group?</label>
                    <textarea class="form-control" name="q2" id="q2"></textarea>
                </div>

            </div>

            <div class="col-2 col-2  text-right">
                <a href="{{ url("members/$member->id/onboarding/".($step+1)) }}" ><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="row mt-4">
            <div class="mx-auto">
                <i class="fa fa-circle mr-1" aria-hidden="true"></i><i class="fa fa-circle mr-1" aria-hidden="true"></i><i class="fa fa-circle mr-1" aria-hidden="true"></i><i class="fa fa-circle-o mr-1" aria-hidden="true"></i><i class="fa fa-circle mr-1" aria-hidden="true"></i> 

            </div>
        </div>

    </div>
@endsection