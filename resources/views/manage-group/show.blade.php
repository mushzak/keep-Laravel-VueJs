@extends('layouts.app')

@section('title', 'Group Profile')

@section('content')
	<div class="container">
        <h2 class="mb-3">Group Profile</h2>

        <group-profile :initial-group="{{ $group->toJson() }}"></group-profile>
    </div>
@endsection