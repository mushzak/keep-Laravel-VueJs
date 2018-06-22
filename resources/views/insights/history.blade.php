@extends('layouts.app')

@section('title', 'Insights')

@section('content')
    <div class="container">
        @include('insights._tabs', ['active' => 'history'])

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