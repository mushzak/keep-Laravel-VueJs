@extends('layouts.app')

@section('title', 'Manage group')

@section('content')
	<div class="container">
        <h2 class="mb-3">Edit group profile</h2>

        <edit-group-profile :initial-group="{{ $group->toJson() }}"></edit-group-profile>
    </div>
@endsection