@extends('layouts.app')

@section('title', 'Member Engagement - Group configuration')

@section('content')
    <div class="container">
        @include('groups.config._tabs', ['active' => 'engagement'])

        <edit-group-member-engagement-form :initial-group="{{ $group->toJson() }}"></edit-group-member-engagement-form>
    </div>
@endsection