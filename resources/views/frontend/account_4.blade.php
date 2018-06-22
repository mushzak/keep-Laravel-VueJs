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
              <a class="nav-link active" href="{{ route('frontend.account_4') }}">Contact Information</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('frontend.account_5') }}">Security Settings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('frontend.account_6') }}">Application Integrations</a>
            </li>
      </ul>

      <h4>Contact Information</h4>
      <form class="col-md-6">
        <div class="form-group">
          <label for="account_name">Account Name</label>
          <input id="account_name" name="account_name" class="form-control" type="text">
        </div>

        <div class="form-group">
          <label for="account_poc_name">Business Name</label>
          <input id="account_poc_name" name="account_poc_name" class="form-control" type="text">
        </div>

        <div class="form-group">
          <label for="account_poc_phone">Business Phone</label>
          <input id="account_poc_phone" name="account_poc_phone" class="form-control" type="tel">
        </div>

        <div class="form-group">
          <label for="account_poc_email">Business Email</label>
          <input id="account_poc_email" name="account_poc_email" class="form-control" type="email">
        </div>

        <p>Insert Account Manager Info Here Read Only</p>   
      
        <div class="form-group pull-right">
          <button href="{{route('frontend.account_2')}}" class="btn bn-primary m-1" type="submit">Save</button>
          <button class="btn bn-primary m-1" type="cancel">Cancel</button>
        </div>
      </form>
  </div>
@endsection