@extends('layouts.app')

@section('title', "Create channel")

@section('content')
    <div class="container">
        <h1>Create a channel</h1>

        <create-channel-form :group="{{ $group->toJson() }}"></create-channel-form>
    </div>
@endsection