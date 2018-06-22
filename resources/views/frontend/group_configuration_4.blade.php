@extends('layouts.app')

@section('title', "Group Configuration")

@section('content')
  <div class="container">
      <div class="row mb-2">
        <div class="col-lg-12">
          <h2>Group Configuration:</h2>
        </div>
      </div>
      <ul class="nav nav-tabs mb-2">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('frontend.group_configuration_1') }}">What We Are About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="{{ route('frontend.group_configuration_2') }}">Agreements</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('frontend.group_configuration_3') }}">Feedback</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="{{ route('frontend.group_configuration_4') }}">Check-Ins</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('frontend.group_configuration_5') }}">Member Plan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('frontend.group_configuration_6') }}">Member Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('frontend.group_configuration_7') }}">Member Engagement</a>
            </li>
      </ul>

      <div class="row mt-2 mb-2">
        <label class="col-form-label mr-1 col-md-4 col-lg-2">
          Frequency:
        </label>
        <select class="form-control col-md-4 col-lg-3">
          <option>No Check-In</option>
          <option>Daily</option>
          <option>Weekly</option>
          <option>Monthly</option>
          <option>Quarterly</option>
        </select>
      </div>
      <div class="row mb-2">
        <label class="col-form-label mr-1 col-md-4 col-lg-2">
          Pace:
        </label>
        <select class="form-control col-md-4 col-lg-3">
          <option>Self Guided</option>
          <option>Coached</option>
        </select>
      </div>
      
      <div class="row form-group pull-right">

        <button href="{{route('frontend.group_configuration_2')}}" class="btn bn-primary m-1" type="cancel">Save</button>
        <button class="btn bn-primary m-1" type="cancel">Cancel</button>
      </div>
  </div>
@endsection