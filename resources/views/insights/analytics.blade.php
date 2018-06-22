@extends('layouts.app')

@section('title', 'Insights')

@section('content')
    <div class="container">
        @include('insights._tabs', ['active' => 'analytics'])

        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-header">
                        Goals and Objectives
                    </div>
                    <div class="card-body">
                        <ranking-chart :members="{{ $members->toJson() }}" value="completed_objectives_count"></ranking-chart>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-header">
                        Commitments
                    </div>
                    <div class="card-body">
                        <ranking-chart :members="{{ $members->toJson() }}" value="completed_commitments_count"></ranking-chart>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-header">
                        Predictor
                    </div>
                    <div class="card-body">
                        <ranking-chart :members="{{ $members->toJson() }}" value="predictor"></ranking-chart>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-header">
                        Engagement
                    </div>
                    <div class="card-body">
                        <ranking-chart :members="{{ $members->toJson() }}" 
                            value="replies_sent_count"></ranking-chart>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection