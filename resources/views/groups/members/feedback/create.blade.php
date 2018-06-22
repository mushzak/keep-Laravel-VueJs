@extends('layouts.app')

@section('title', "Give Feedback")

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        Members
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($otherMembers as $otherMember)
                            <a class="list-group-item {{ $member->id == $otherMember->id ? 'active' : '' }}"
                               href="{{ route('groups.members.give-feedback', [$group->slug, $otherMember->id]) }}">
                                {{ $otherMember->user->name }}
                            </a>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col">
                <leave-feedback
                        action="{{ route('api.members.feedbacks.store', $member->id) }}"
                        :member="{{ $member->toJson() }}"
                        :template="{{ $feedback->toJson() }}">
                </leave-feedback>
            </div>
        </div>
    </div>
@endsection