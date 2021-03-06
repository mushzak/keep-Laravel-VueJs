@extends('layouts.app')

@section('title', 'Manage members')

@section('content')
    <div class="container">
        <h2 class="mb-3">Manage invited members</h2>

        <ul class="nav nav-tabs mb-3">
           <li class="nav-item">
                <a class="nav-link" href="{{ route('manage-members.index') }}">Members</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('manage-members.invites.index') }}">Invites</a>
            </li>
        </ul>

        <manage-invites :group="{{ $group->toJson() }}" :invites="{{$invites->toJson()}}"></manage-invites>
    </div>
@endsection