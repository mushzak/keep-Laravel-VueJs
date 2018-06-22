@extends('layouts.app')

@section('title', 'Feedback - Group configuration')

@section('content')
    <div class="container">
        @include('groups.config._tabs', ['active' => 'feedback'])

        <edit-group-feedback-form :initial-group="{{ $group->toJson() }}"></edit-group-feedback-form>
    </div>
@endsection