@extends('layouts.app')

@section('title', 'Verification - Onboarding')

@section('content')
    <div class="container">
        <div class="mb-3">
            <h2>New Group Member Registration</h2>
            <h4>
                <small>Please verify your information is correct</small>
            </h4>
        </div>

        <onboarding-verify-form :member="{{ $member->toJson() }}"></onboarding-verify-form>
    </div>
@endsection