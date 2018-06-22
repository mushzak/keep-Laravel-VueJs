@extends('layouts.app')

@section('title', 'Expectations - Onboarding')

@section('content')
    <div class="container">

        <div class="mb-3 d-flex">
            <div class="mx-auto">
                <h2>Expectations</h2>
            </div>
        </div>

        <form method="POST" action="{{ route('onboarding.agreements') }}">
            {{ csrf_field() }}

            <div class="row align-items-center mb-3">
                <div class="col-2 text-left">
                    <a href="{{ action('Onboarding\AgreementController') }}">
                        <i class="fa fa-5x fa-chevron-circle-left"></i>
                    </a>
                </div>

                <onboarding-expectations-form :member="{{ $member->toJson() }}" :questions="{{ $questions->toJson() }}"></onboarding-expectations-form>
            </div>
        </form>

        @include('onboarding._circles', ['current' => 4, 'total' => 5])
    </div>
@endsection