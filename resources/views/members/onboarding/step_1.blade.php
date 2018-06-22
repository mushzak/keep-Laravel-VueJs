@extends('layouts.app')

@section('title', 'New Group Member Registration')

@section('content')
    <div class="container">
        <div class="mb-4">
            <H2>New Group Member Registraion</H2>
            <h4>
                <small>Please verify your information is correct</small>
            </h4>
        </div>

        <div class="form-group row">
            <label for="name" class="col-4 col-form-label">Name</label>
            <div class="col-6">
                <input class="form-control" type="text" name="name" id="name" value="{{$member->user->name}}">
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-4 col-form-label">Email</label>
            <div class="col-6">
                <input class="form-control" type="text" name="email" id="email" value="{{$member->email}}">
            </div>
        </div>

        <div class="row">
            <div class="col-12"><u>Text Enabled</u></div>
        </div>

        <div class="form-group row">
            <label for="receives_text" class="col-4 col-form-label"> Do you use text messaging?</label>
            <div class="col-6">
                <input class="mt-3 form-chck-input" type="checkbox" name="receives_text" id="receives_text">
            </div>
        </div>

        <div class="form-group row">
            <label for="text_number" class="col-4 col-form-label"> Text Number</label>
            <div class="col-6">
                <input class="form-control" type="tel" name="text_number" id="text_number">
            </div>
        </div>

        <div class="row">
            <div class="col-12"><u>Security</u></div>
        </div>

        <div class="form-group row">
            <label for="two_factor" class="col-4 col-form-label"> Enable 2 Factor Authetication</label>
            <div class="col-6">
                <input class="mt-3 form-chck-input" type="checkbox" name="two_factor" id="two_factor">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-6 offset-md-3">

                <a href="{{url("members/$member->id/onboarding/2") }}">
                    <button type="submit" class="btn btn-primary mr-4 mb-4">Save and Continue</button>
                </a>
                <button type="submit" class="btn btn-primary mr-4 mb-4">Cancel</button>
            </div>
        </div>
    </div>
@endsection