@extends('layouts.app')

@section('title', "Edit channel")

@section('content')
    <div class="container">
        <h1>Edit a channel</h1>

        <edit-channel-form :group="{{ $group->toJson() }}" :channel="{{ $channel->toJson() }}"></edit-channel-form>
    </div>
@endsection