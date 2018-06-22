@extends('layouts.app')

@section('title', 'Analytics')

@section('content')
    <div class="container">
        {{-- Breadcrumbs removed per Alan --}}
        {{--<ol class="breadcrumb">--}}
            {{--<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('groups.member-dashboard', $group->slug) }}">{{ $group->name }}</a></li>--}}
            {{--<li class="breadcrumb-item active">Analytics</li>--}}
        {{--</ol>--}}

        <h1 class="mb-3">Analytics</h1>

        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-header">
                        Goals and Objectives
                    </div>
                    <div class="card-body">
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
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-header">
                        Commitments
                    </div>
                    <div class="card-body">
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
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-header">
                        Predictor
                    </div>
                    <div class="card-body">
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
    </div>
@endsection