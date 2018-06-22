@extends('layouts.app')

@section('title', "Profile")

@section('content')
    <div class="container">
        <edit-personal-background :member="{{ $member->toJson() }}" action="{{ route('api.members.update', $member->id) }}"></edit-personal-background>
        <edit-professional-background :member="{{ $member->toJson() }}" action="{{ route('api.members.update', $member->id) }}"></edit-professional-background>
        <edit-contact-info :member="{{ $member->toJson() }}" action="{{ route('api.members.update', $member->id) }}"></edit-contact-info>
    </div>
@endsection