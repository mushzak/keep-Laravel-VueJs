@extends('layouts.app')

@section('title', "Editing profile - {$member->user->name}")

@section('content')
    <div class="container">
        <h1 class="mb-3">Editing profile <small>{{ $member->user->name }}</small></h1>

        <edit-personal-background :member="{{ $member->toJson() }}"></edit-personal-background>
        <edit-professional-background :member="{{ $member->toJson() }}"></edit-professional-background>
        <edit-contact-info :member="{{ $member->toJson() }}"></edit-contact-info>
    </div>
@endsection