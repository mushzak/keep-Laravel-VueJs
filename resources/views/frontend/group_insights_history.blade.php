@extends('layouts.app')

@section('title', "Group Insights")

@section('content')
  <div class="container">
      <div class="row">
        <div class="col-lg-12">

          <h2>Group Insights</h2>

          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('frontend.group_insights_1') }}">Analytics</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="{{ route('frontend.group_insights_2') }}">Feedback</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="{{ route('frontend.group_insights_3') }}">History</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="row">
        @foreach($members as $member)     
            <div class=col-md-12>
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
                              <div>
                                  <span><h4>5 of 10</h4></span>
                              </div>
                          </div>
                          <div class="col-md-8 col-lg-10">
                              <ul class="list-group border-0">
                                <li class="list-group-item border-0">
                                  <h4 class="card-title">
                                      <a href="{{ route('groups.profiles.show', [$group->slug, $member->id]) }}">
                                          {{ $member->user->name }}
                                      </a>
                                  </h4>
                                </li>
                  
                                <li class="list-group-item border-0"><b>What do you expect from this group</b></li>
                                <li class="list-group-item border-0">argarwg aewrg erwg earg aerg earg earg earg earg earg earg earg aerg</li>
                                <li class="list-group-item border-0"><b>Who recommeded you to this group</b></li>
                                <li class="list-group-item border-0">Porta ac consectetur ac</li>
                                <li class="list-group-item border-0 text-right mb-0 pb-0">January 2, 2018</li>
                              </ul>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        @endforeach 

        @foreach($members as $member)     
            <div class=col-md-12>
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
                              <div>
                                  <span><h4>8 of 10</h4></span>
                              </div>
                          </div>
                          <div class="col-md-8 col-lg-10">
                              <ul class="list-group border-0">
                                <li class="list-group-item border-0">
                                  <h4 class="card-title">
                                      <a href="{{ route('groups.profiles.show', [$group->slug, $member->id]) }}">
                                          {{ $member->user->name }}
                                      </a>
                                  </h4>
                                </li>
                  
                                <li class="list-group-item border-0"><b>What do you expect from this group</b></li>
                                <li class="list-group-item border-0">argarwg aewrg erwg earg aerg earg earg earg earg earg earg earg aerg</li>
                                <li class="list-group-item border-0"><b>Who recommeded you to this group</b></li>
                                <li class="list-group-item border-0">Porta ac consectetur ac</li>
                                <li class="list-group-item border-0 text-right mb-0 pb-0">July 5, 2017</li>
                              </ul>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        @endforeach          

      </div>
  </div>
@endsection