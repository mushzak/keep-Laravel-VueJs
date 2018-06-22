@extends('layouts.app')

@section('title', 'Member profiles - Group configuration')

@section('content')
    <div class="container">
        @include('groups.config._tabs', ['active' => 'profiles'])

        <edit-group-member-profile-form :initial-group="{{ $group->toJson() }}"></edit-group-member-profile-form>
    </div>
@endsection