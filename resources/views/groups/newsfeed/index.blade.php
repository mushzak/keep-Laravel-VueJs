@extends('layouts.app')

@section('title', "View Feedback")

@section('content')
    <div class="container">
        <news-feed
            action="{{ route('api.members.comments.store', $member->id) }}"
            :member="{{ $member->toJson() }}"
            :auth="{{ auth()->user()->toJson() }}">
        </news-feed>
    </div>
@endsection