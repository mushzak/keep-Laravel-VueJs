@extends('layouts.app')

@section('title', "Group Insights")

@section('content')
  <div class="container">
      <div class="row">
        <div class="col-lg-12">

          <h2>Group Insights</h2>

          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link active" href="#">Analytics</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('frontend.group_insights_2') }}">Feedback</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('frontend.group_insights_3') }}">History</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="row mt-5">
          <div class="col-lg-6">
              <div class="card mb-3">
                  <div class="card-header">
                      Progress
                  </div>
                  <div class="card-body">
                      <ranking-chart></ranking-chart>
                  </div>
              </div>
          </div>

          <div class="col-lg-6">
              <div class="card mb-3">
                  <div class="card-header">
                       Effort
                  </div>
                  <div class="card-body">
                     <ranking-chart></ranking-chart>
                  </div>
              </div>
          </div>
          <div class="col-lg-6">
              <div class="card mb-3">
                  <div class="card-header">
                       Predictor
                  </div>
                  <div class="card-body">
                     <ranking-chart></ranking-chart>
                  </div>
              </div>
          </div>
          <div class="col-lg-6">
              <div class="card mb-3">
                  <div class="card-header">
                       Engagement
                  </div>
                  <div class="card-body">
                     <ranking-chart></ranking-chart>
                  </div>
              </div>
          </div>

      </div>
  </div>
@endsection