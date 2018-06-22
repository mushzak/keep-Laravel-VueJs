@extends('layouts.app')

@section('title', 'Facilitator settings')

@section('content')
    <div class="container">
        {{-- Breadcrumbs removed per Alan --}}
        {{--<ol class="breadcrumb">--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>--}}
            {{--<li class="breadcrumb-item active">Facilitator settings</li>--}}
        {{--</ol>--}}

        <h1 class="mb-3">Facilitator settings</h1>

        <manage-check-in-form :group="{{ $group->toJson() }}"></manage-check-in-form>

        <finish-process-form :group="{{ $group->toJson() }}"></finish-process-form>
    </div>
@endsection