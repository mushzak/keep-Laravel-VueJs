@extends('layouts.app')

@section('title', 'Member plan - Group configuration')

@section('content')
    <div class="container">
        @include('groups.config._tabs', ['active' => 'planning'])

        <edit-group-member-plan-form :initial-group="{{ $group->toJson() }}"></edit-group-member-plan-form>
    </div>
@endsection