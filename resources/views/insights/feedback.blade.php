@extends('layouts.app')

@section('title', 'Insights')

@section('content')
    <div class="container">
        @include('insights._tabs', ['active' => 'feedback'])

        <div class="mb-3">
            <div class="row align-items-center">
                <div class="col-md">
                    <h3 class="mr-5 text-center">
                        Overall: <b>{{ round($average, 1) }}</b>
                    </h3>
                </div>
                <div class="col-md">
                    <div class="card mb-3">
                        <div class="card-header">
                            Action items
                        </div>
                        @if ($group->flags()->activeOnly()->count())
                            @foreach ($group->flags()->activeOnly()->get() as $flag)
                                <a href="{{ $flag->link() }}" class="list-group-item list-group-item-action">
                                    {{ __("flags.{$flag->type}") }}
                                </a>
                            @endforeach
                        @else
                            <div class="card-body">
                                <p class="mb-0 lead text-center text-success">Nothing right now. Good job.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @foreach ($members as $member)
            <div class="card mb-3">
                <div class="card-header">
                    <a href="{{ route('groups.profiles.show', [$member->group->slug, $member->id]) }}">
                        {{ $member->user->name }}
                    </a>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 col-lg-2 text-center">
                            @include('common._avatar')
                        </div>
                        <div class="col-md-8 col-lg-10">
                            @if ($member->feedback->count())
                                @foreach ($member->feedback as $feedback)
                                    <h4 class="card-title">
                                        {{ $feedback->question->content }}
                                    </h4>

                                    <p>{{ $feedback->content }}</p>

                                    @if ($feedback->rating)
                                        <p class="text-muted">Rating: <b>{{ $feedback->rating }}</b> / 10</p>
                                    @endif
                                @endforeach
                            @else
                                <p class="text-danger">This user has not yet provided feedback.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection