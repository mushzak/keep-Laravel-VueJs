@extends('layouts.app')

@section('title', "Account")

@section('content')
  <div class="container">
      <div class="row mb-2">
        <div class="col-lg-12">
          <h2>Account Manager:</h2>
        </div>
      </div>
      <ul class="nav nav-tabs mb-2">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('frontend.account_1') }}">Subscription Plan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('frontend.account_2') }}">Group Management</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="{{ route('frontend.account_3') }}">Branding</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('frontend.account_4') }}">Contact Information</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('frontend.account_5') }}">Security Settings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="{{ route('frontend.account_6') }}">Application Integrations</a>
            </li>
      </ul>

      <h4>Application Integration</h4>
      
      <form class="col-md-6">
        <div class="form-check">
          <label class="form-check-label">
              <input class="form-check-input" type="checkbox">
            App Name</label>
        </div>
      
        <div class="form-group pull-right">
          <button href="{{route('frontend.account_2')}}" class="btn bn-primary m-1" type="submit">Save</button>
          <button class="btn bn-primary m-1" type="cancel">Cancel</button>
        </div>
      </form>
  </div>
@endsection