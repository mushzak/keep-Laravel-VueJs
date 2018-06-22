@extends('layouts.app')

@section('title', $member->user->name)

@section('content')
    <div class="container">
        <div class="d-flex">
            <h1 class="mb-3 mr-auto">{{ $member->user->name }}</h1>

            @can('update', $member)
                <div>
                    <a href="{{ route('groups.profiles.edit', [$group->slug, $member->id]) }}" class="btn btn-outline-primary ml-1">
                        Edit profile
                    </a>
                    <a href="{{ route('groups.profiles.plan.edit', [$group->slug, $member->id]) }}" class="btn btn-outline-primary ml-1">
                        Edit plan
                    </a>
                </div>
            @endcan
        </div>

        <div class="row align-items-center">
            <div class="col-lg-6 col-xl-3 text-center">
                @if ($member->personal_avatar)
                    <img src="{{ Storage::url($member->personal_avatar) }}" alt="{{ $member->user->name }}"
                         class="img-thumbnail rounded-circle mb-3"/>
                @else
                    <div class="img-thumbnail rounded-circle mx-auto d-flex flex-column justify-content-center mb-3"
                         style="width: 150px; height: 150px">
                        <span class="fa fa-5x fa-user"></span>
                    </div>
                @endif
            </div>
            <div class="col-lg-6 col-xl-3">
                <div class="card mb-3">
                    <div class="card-header">
                        Progress
                    </div>
                    @if (auth()->user()->activeGroupMember->id==$member->id)
                        <a class="dmh-no-style-href" href="{{route('groups.analytics.index',['group'=>$group->slug])}}">
                    @endif

                    <div class="card-body">
                        @include('metrics._progress_metric', ['member'=>$member, 'graph_only'=>true])
                    </div>

                    @if (auth()->user()->activeGroupMember->id==$member->id)
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-lg-6 col-xl-3">
                <div class="card mb-3">
                    
                    <div class="card-header">
                        Effort
                    </div>
                    @if (auth()->user()->activeGroupMember->id==$member->id)
                        <a class="dmh-no-style-href" href="{{route('groups.analytics.index',['group'=>$group->slug])}}">
                    @endif
                    <div class="card-body">
                        @include('metrics._effort_metric', ['member'=>$member, 'graph_only'=>true])
                    </div>
                    @if (auth()->user()->activeGroupMember->id==$member->id)
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-lg-6 col-xl-3">
                <div class="card mb-3">
                    
                    <div class="card-header">
                        Predictor
                    </div>
                    @if (auth()->user()->activeGroupMember->id==$member->id)
                        <a class="dmh-no-style-href" href="{{route('groups.analytics.index',['group'=>$group->slug])}}">
                    @endif
                    <div class="card-body">
                        @include('metrics._predictor_metric', compact('member'))
                    </div>
                    @if (auth()->user()->activeGroupMember->id==$member->id)
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <action-plan :member="{{ $member->toJson() }}"
            :group="{{ $group->toJson() }}"></action-plan>
        <goals-and-objectives :member="{{ $member->toJson() }}"></goals-and-objectives>
        <big-picture :member="{{ $member->toJson() }}"></big-picture>
        <personal-motivation :member="{{ $member->toJson() }}"></personal-motivation>
        <personal-background :member="{{ $member->toJson() }}"></personal-background>
        <professional-background :member="{{ $member->toJson() }}"></professional-background>
        <contact-info :member="{{ $member->toJson() }}"></contact-info>
    </div>
@endsection