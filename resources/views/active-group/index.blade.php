@extends('layouts.app')

@section('title', 'Select active group')

@section('content')
    <div class="container">
        <h1 class="mb-3">Select current group</h1>

        @if ($groups->count())
            <div class="list-group">
                @foreach ($groups as $group)
                    <post-request-link
                            href="{{ route('active-group.update', $group->slug) }}"
                            method="PATCH"
                            class="list-group-item list-group-item-action {{ $group->id === auth()->user()->active_group_id ? 'active' : '' }}">
                        <div class="d-flex w-100 justify-content-between">
                            <h5>{{ $group->name }}</h5>
                            @if ($group->id === auth()->user()->active_group_id)
                                <small>currently active</small>
                            @endif
                        </div>
                        <p>{{ $group->description }}</p>
                        <small>Facilitator: {{ ($group->facilitator?$group->facilitator->name : 'TBD') }}</small>

                    </post-request-link>
                @endforeach
            </div>
        @else
            <p class="lead text-danger">You aren't a member of any groups.</p>
            <p>Once you join a group, you can select it as your active group from this page.</p>
        @endif
    </div>
@endsection