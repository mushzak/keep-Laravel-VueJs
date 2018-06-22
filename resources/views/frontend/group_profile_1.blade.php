@extends('layouts.app')

@section('title', "Edit Group Profile")

@section('content')
  <div class="container">
      <div class="row mb-2">
        <div class="col-lg-12">
          <h2>Edit Group Profile</h2>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-2">
           <div class="col-sm-2 col-lg-1 ">
                    <a href="#!" class="text-info text-center align-self-top">
                        <img src="`/storage/{{$group->avatar}}`"
                             alt="{{$group->name}}"
                             class="img-thumbnail rounded-circle "
                             style="height:50px"
                             v-if="{{$group->avatar}}"/>

                        <div class="img-thumbnail mx-auto d-flex flex-column justify-content-center "
                             style="height:50px"
                             v-else>
                            <span class="fa fa-2x fa-user"></span>
                        </div>
                    </a>

                </div>
          upload
        </div>
        
        <label class="col-form-label col-sm-2 col-lg-1">
          Name:
        </label>
        <input type="text" class="form-control col-sm-8 col-lg-9" placeholder="Enter Name Here" value="Chum"></input>
      </div>
      <div class="form-group row">
        <label class="col-form-label col-sm-2">
          Purpose
        </label>
        <textarea class="form-control col-sm-10" rows="5" placeholder="Enter Purpose Here"></textarea>
      </div>
      <div class="form-group row">
        <label class="col-form-label col-sm-2">
          Slogan
        </label>
        <textarea class="form-control col-sm-10" rows="5" placeholder="Enter Slogan Here"></textarea>
      </div>
      <div class="form-group row">
        <label class="col-form-label col-sm-2">
          Location
        </label>
        <textarea class="form-control col-sm-10" rows="5" placeholder="Enter Location Here"></textarea>
      </div>
      <div class="form-group row">
        <label class="col-form-label col-sm-2">
          Contact
        </label>
        <textarea class="form-control col-sm-10" rows="5" placeholder="Enter Contact Here"></textarea>
      </div>
      <div class="form-group row">
        <label class="col-form-label col-sm-2">
          Description
        </label>
        <textarea class="form-control col-sm-10" rows="5" placeholder="Enter Description Here"></textarea>
      </div>
      <div class="row form-group pull-right">
        <button class="btn bn-primary m-1" type="submit">Save</button>
        <button class="btn bn-primary m-1" type="cancel">Cancel</button>
      </div>
  </div>
@endsection