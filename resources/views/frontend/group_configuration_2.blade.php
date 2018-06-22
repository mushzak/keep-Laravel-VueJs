@php 
//TODO replace this variable with backend data
$screen1=new class{};
$screen1->order= 1;
$screen1->description='don\' tell anyone anything';
$screen2=new class{};
$screen2->order= 2;
$screen2->description='you have the right to remain silent';
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
              <a class="nav-link active" href="{{ route('frontend.group_configuration_2') }}">Agreements</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('frontend.group_configuration_3') }}">Feedback</a>
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
          Screen {{$screen->order}}:
        </label>
        <textarea class="form-control col-sm-7 col-lg-9" rows="5" placeholder="Agreements">{{$screen->description}}</textarea>
        <div class="col-1 ">
          <button class="btn bn-primary m-1 p-1">Remove</button>
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