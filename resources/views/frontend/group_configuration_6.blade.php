@php 
//TODO replace this variable with backend data
$config=new class{};
$config->ask_name= 'Ask';
$config->is_ask=(bool)True;
$config->backstory_name= 'Backstory';
$config->is_backstory=(bool)True;
$config->outcome_name= 'Outcome';
$config->is_outcome=(bool)True;
$config->commitment_name= 'Commitment';
$config->is_goals_and_objectives=(bool)True;
$config->goal_name= 'Goal';
$config->objective_name= 'Objective';
$config->is_big_picture=(bool)True;
$config->vision_name= 'Vision';
$config->values_name= 'Values';
$config->mission_name= 'Mission';
$config->is_personal_motivation=(bool)True;
$config->why_name= 'Why';
$config->consequences_name= 'Consequences';
$config->is_professional_background=(bool)True;
$config->company_name= 'Company Name';
$config->company_bio_name= 'Company Bio';
//TODO Replace above
@endphp

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
              <a class="nav-link " href="{{ route('frontend.group_configuration_4') }}">Check-Ins</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('frontend.group_configuration_5') }}">Member Plan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="{{ route('frontend.group_configuration_6') }}">Member Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('frontend.group_configuration_7') }}">Member Engagement</a>
            </li>
      </ul>


      <b>Big Picture</b>
      <input id="is_ask" class="ml-1" type="checkbox" @if ($config->is_big_picture) checked @endif >
      <div class="row mt-2 mb-2">
        <label class="col-form-label mr-1 col-sm-3 col-lg-2">
          Vision:
        </label>
        <input class="form-control col-sm-8 col-lg-9" type="text" value="{{$config->vision_name}}">
      </div>
      <div class="row mt-2 mb-2">
        <label class="col-form-label mr-1 col-sm-3 col-lg-2">
          Values:
        </label>
        <input class="form-control col-sm-8 col-lg-9" type="text" value="{{$config->values_name}}">
      </div>
      <div class="row mt-2 mb-2">
        <label class="col-form-label mr-1 col-sm-3 col-lg-2">
          Mission:
        </label>
        <input class="form-control col-sm-8 col-lg-9" type="text" value="{{$config->mission_name}}">
      </div>

      <br>
      <b>Personal Motivation</b>
      <input id="is_ask" class="ml-1" type="checkbox" @if ($config->is_personal_motivation) checked @endif >
      <div class="row mt-2 mb-2">
        <label class="col-form-label mr-1 col-sm-3 col-lg-2">
          Why:
        </label>
        <input class="form-control col-sm-8 col-lg-9" type="text" value="{{$config->why_name}}">
      </div>
      <div class="row mt-2 mb-2">
        <label class="col-form-label mr-1 col-sm-3 col-lg-2">
          Consequences:
        </label>
        <input class="form-control col-sm-8 col-lg-9" type="text" value="{{$config->consequences_name}}">
      </div>

      <br>
      <b>Professional Background</b>
      <input id="is_ask" class="ml-1" type="checkbox" @if ($config->is_professional_background) checked @endif >
      <div class="row mt-2 mb-2">
        <label class="col-form-label mr-1 col-sm-3 col-lg-2">
          Company Name:
        </label>
        <input class="form-control col-sm-8 col-lg-9" type="text" value="{{$config->company_name}}">
      </div>
      <div class="row mt-2 mb-2">
        <label class="col-form-label mr-1 col-sm-3 col-lg-2">
          Company Bio:
        </label>
        <input class="form-control col-sm-8 col-lg-9" type="text" value="{{$config->company_bio_name}}">
      </div>
      
      <div class="row form-group pull-right">

        <button href="{{route('frontend.group_configuration_2')}}" class="btn bn-primary m-1" type="cancel">Save</button>
        <button class="btn bn-primary m-1" type="cancel">Cancel</button>
      </div>
  </div>
@endsection