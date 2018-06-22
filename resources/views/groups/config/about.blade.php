@extends('layouts.app')

@section('title', 'What We Are About - Group configuration')

@section('content')
    <div class="container">
        @include('groups.config._tabs', ['active' => 'about'])

        <edit-group-about-form :initial-group="{{ $group->toJson() }}"></edit-group-about-form>
    </div>
@endsection