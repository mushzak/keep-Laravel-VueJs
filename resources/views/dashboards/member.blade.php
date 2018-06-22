@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card mb-3">
                    <div class="card-header">
                        Action items
                    </div>
                    @php $action_count=0 @endphp

                    @if($member->group->account->manager && $member->user->id==$member->group->account->manager->id)
                        @foreach ($member->group->account->flags()->activeOnly()->get() as $flag)
                            <a href="{{ $flag->link() }}" class="list-group-item list-group-item-action">
                                {{ __("flags.{$flag->type}") }}
                            </a>
                            @php $action_count++ @endphp
                        @endforeach
                    @endif

                    @if($member->group->facilitator && $member->user->id==$member->group->facilitator->id)
                        @foreach ($member->group->flags()->activeOnly()->get() as $flag)
                                <a href="{{ $flag->link() }}" class="list-group-item list-group-item-action">
                                    {{ __("flags.{$flag->type}") }}
                                </a>
                                @php $action_count++ @endphp
                        @endforeach
                    @endif

                    @if ($member->flags()->activeOnly()->count())
                        @foreach ($member->flags()->activeOnly()->get() as $flag)
                            <a href="{{ $flag->link() }}" class="list-group-item list-group-item-action">
                                {{ __("flags.{$flag->type}") }}
                            </a>
                            @php $action_count++ @endphp
                        @endforeach

                    @endif
                    @if ($action_count==0)
                        <div class="card-body">
                            <p class="mb-0 lead text-center text-success">Nothing right now. Good job.</p>
                        </div>
                    @endif

                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card mb-3">
                    <div class="card-header">
                        Current commitment
                    </div>
                    <div class="card-body">
                        <a class="dmh-no-style-href" href="{{ route('groups.profiles.plan.edit', ['group'=>auth()->user()->activeGroup->slug, 'member'=>auth()->user()->activeGroupMember->id] ) }}">
                            <p class="lead mb-0">
                                @if ($member->lastCommitment && !$member->lastCommitment->name==null)
                                      <div class="dmh-commitment"> "{{ $member->lastCommitment->name }}"</div>
                                @else
                                    <span class="text-danger">No commitment has been added.</span>
                                @endif
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            Progress
                        </div>
                        <a class="dmh-no-style-href" href="{{route('groups.analytics.index',['group'=>$group->slug])}}">
                            <div class="card-body">
                                @include('metrics._progress_metric', ['member'=>$member, 'graph_only'=>true])
                            </div>
                        </a>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card mb-3">
                    <div class="card-header">
                        Commitments
                    </div>
                    <a class="dmh-no-style-href" href="{{route('groups.analytics.index',['group'=>$group->slug])}}">
                        <div class="card-body">
                            @include('metrics._effort_metric', ['member'=>$member, 'graph_only'=>true])
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card mb-3">
                    <div class="card-header">
                        Predictor
                    </div>
                    <a class="dmh-no-style-href" href="{{route('groups.analytics.index',['group'=>$group->slug])}}">
                        <div class="card-body">
                            @include('metrics._predictor_metric', compact('member'))
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection