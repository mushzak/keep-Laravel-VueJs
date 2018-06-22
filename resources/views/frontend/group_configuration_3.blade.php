@php 
//TODO replace this variable with backend data
$screen1=new class{};
$screen1->order= 1;
$screen1->description='What do you want to get out of this meeting';
$screen1->is_new_member=(bool)true;
$screen1->is_active=(bool)true;
$screen2=new class{};
$screen2->order= 2;
$screen2->description='Is your facilitator effective';
$screen2->is_new_member=(bool)false;
$screen2->is_active=(bool)true;
$screens=[$screen1,$screen2];
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
              <a class="nav-link active" href="{{ route('frontend.group_configuration_3') }}">Feedback</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('frontend.group_configuration_4') }}">Check-Ins</a>
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

      @foreach($screens as $screen)
      <div class="form-group row">
        <label class="col-form-label mr-1 col-sm-3 col-lg-1">
          Question {{$screen->order}}:
        </label>
        <textarea class="form-control col-sm-7 col-lg-9" rows="5" placeholder="Agreements">{{$screen->description}}</textarea>
        <div class="col-1 ">
          <button class="btn bn-primary m-1 p-1">Remove</button>
        </div>
      </div>
      <div class="form-group row">
        
        <div class="mr-1 col-sm-3 col-lg-1">
          
        </div>
        <div class="col-sm-8 col-lg-9">
          <div> <input id="is_new_member" type="checkbox" @if ($screen->is_new_member) checked @endif ><label class="ml-1">New Member Only</label></div>
          <div> <input id="is_new_member" type="checkbox" @if ($screen->is_active) checked @endif ><label class="ml-1">Active</label></div>
        </div>



      </div>
      
      @endforeach
      
      <div class="row form-group pull-right">
        <button class="btn bn-primary m-1" type="submit">Add</button>
        <button href="{{route('frontend.group_configuration_2')}}" class="btn bn-primary m-1" type="cancel">Save</button>
        <button class="btn bn-primary m-1" type="cancel">Cancel</button>
      </div>
  </div>
@endsection