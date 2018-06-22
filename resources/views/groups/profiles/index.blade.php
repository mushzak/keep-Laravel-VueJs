@extends('layouts.app')

@section('title', 'Profiles')

@section('content')
    <div class="container">
        {{-- Breadcrumbs removed per Alan --}}
        {{--<ol class="breadcrumb">--}}
            {{--<li class="breadcrumb-item">--}}
                {{--<a href="{{ url('/') }}">Home</a>--}}
            {{--</li>--}}
            {{--<li class="breadcrumb-item">--}}
                {{--<a href="{{ route('groups.member-dashboard', $group->slug) }}">{{ $group->name }}</a>--}}
            {{--</li>--}}
            {{--<li class="breadcrumb-item active">--}}
                {{--Profiles--}}
            {{--</li>--}}
        {{--</ol>--}}

        <h1 class="mb-3">Members</h1>

        @foreach ($members as $member)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 col-lg-2 text-center">
                            
                            <div>
                                <a href="{{ route('groups.profiles.show', [$group->slug, $member->id]) }}">
                                    @if ($member->personal_avatar)
                                        <img src="{{ Storage::url($member->personal_avatar) }}"
                                             alt="{{ $member->user->name }}"
                                             class="img-thumbnail rounded-circle mb-3"/>
                                    @else
                                        <div class="img-thumbnail rounded-circle mx-auto d-flex flex-column justify-content-center mb-3"
                                             style="width: 150px; height: 150px">
                                            <span class="fa fa-5x fa-user"></span>
                                        </div>
                                    @endif
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-4">
                            <h4 class="card-title">
                                <a href="{{ route('groups.profiles.show', [$group->slug, $member->id]) }}">
                                    {{ $member->user->name }}
                                </a>
                            </h4>

                            @if ($member->lastGoal)
                                <h4><small> {{ $member->lastGoal->name }}</small></h4>
                            @endif

                            @if ($member->lastCommitment)
                               {{ $member->lastCommitment->name }} 
                            @endif                          
                            
                        </div>
                        <div class="col-4 col-lg-2">
                            <base-modal
                                title="Goals and Objectives"
                                :show-modal-button-classes="[]"
                                v-cloak>
                                <div slot="button">
                                    @include('metrics._progress_metric', ['member'=>$member, 'graph_only'=>true])  
                                </div>
                                    @include('metrics._progress_metric', ['member'=>$member, 'graph_only'=>false, 'show_description'=>true])
                            </base-modal>
                            
                        </div>
                        <div class="col-4 col-lg-2">
                            <base-modal
                                title="Commitments"
                                :show-modal-button-classes="[]"
                                v-cloak>
                                <div slot="button">
                                    @include('metrics._effort_metric', ['member'=>$member, 'graph_only'=>true])
                                </div>
                                    @include('metrics._effort_metric', ['member'=>$member, 'graph_only'=>false, 'show_description'=>true])
                            </base-modal>
                        </div>

                        <div class="col-4 col-lg-2">
                            <base-modal
                                title="Predictor"
                                :show-modal-button-classes="[]"
                                v-cloak>
                                <div slot="button">
                                @include('metrics._predictor_metric', compact('member'))
                                </div>
                                @include('metrics._predictor_metric', ['member'=>$member, 'show_description'=>true])
                            </base-modal>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection