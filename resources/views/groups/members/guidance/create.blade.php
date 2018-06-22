@extends('layouts.app')

@section('title', "Give Guidance")

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        Members
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($members as $otherMember)
                            <a class="list-group-item {{ $member->id == $otherMember->id ? 'active' : '' }}"
                               href="{{ route('groups.members.give-guidance', [$group->slug, $otherMember->id]) }}">
                                {{ $otherMember->user->name }}
                            </a>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col">
                @include('groups.profiles._personal_background')
                @include('groups.profiles._professional_background')
                @include('groups.profiles._big_picture')
                @include('groups.profiles._goals_and_objectives')
                @include('groups.profiles._personal_motivations')
                @include('groups.members.guidance._current_action_plan')

                @if ($member->user_id !== auth()->id())
                    <news-feed
                            action="{{ route('api.members.comments.store', $member->id) }}"
                            :member="{{ $member->toJson() }}"
                            :auth="{{ auth()->user()->toJson() }}">
                    </news-feed>
                @endif
            </div>
        </div>
    </div>
@endsection