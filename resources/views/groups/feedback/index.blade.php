@extends('layouts.app')

@section('title', "View Feedback")

@section('content')
    <div class="container">
        <h1>Give feedback</h1>

        <create-feedback-form :group="{{ $group->toJson() }}" :member="{{ $member->toJson() }}" :questions="{{ $questions->toJson() }}"></create-feedback-form>
    </div>
@endsection