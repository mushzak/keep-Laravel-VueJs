@extends('layouts.app')

@section('title', "Editing plan - {$member->user->name}")

@section('content')
    <div class="container">
        <h1 class="mb-3">Editing plan <small>{{ $member->user->name }}</small></h1>

        <edit-action-plan :member="{{ $member->toJson() }}"></edit-action-plan>
        <edit-goals-and-objectives :member="{{ $member->toJson() }}"></edit-goals-and-objectives>
        <edit-big-picture :member="{{ $member->toJson() }}" ></edit-big-picture>
        <edit-personal-motivation :member="{{ $member->toJson() }}"></edit-personal-motivation>
    </div>
@endsection