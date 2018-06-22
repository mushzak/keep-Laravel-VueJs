@extends('layouts.app')

@section('title', "Discussion")

@section('content')
    <div class="container">
        <discussion-room
                :group="{{ $group->toJson() }}"
                :initial-channel="{{ $channel->toJson() }}"
                :auth="{{ auth()->user()->toJson() }}"
                :is-facilitator.boolean="{{ auth()->user()->can('facilitate', $group) ? 'true' : 'false' }}"></discussion-room>
    </div>
@endsection