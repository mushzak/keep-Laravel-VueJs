@extends('layouts.app')

@section('title', 'Insights')

@section('content')
    <div class="container">
        @include('insights._tabs', ['active' => 'praise'])

        <div class="list-group">
            @foreach ($members as $member)
                <a href="{{ route('members.discussions.create', $member->id) }}" class="list-group-item list-group-item-action">{{ $member->user->name }}</a>
            @endforeach
        </div>
    </div>
@endsection