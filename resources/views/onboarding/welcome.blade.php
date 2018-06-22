@extends('layouts.app')

@section('title', 'Welcome - Onboarding')

@section('content')
    <div class="container">
        <div class="mb-3 d-flex">
            <div class="mx-auto">
                <h2>Welcome</h2>
            </div>
        </div>

        <div class="row align-items-center mb-3">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-body" v-cloak>
                        @if ($member->group->welcome)
                            <text-decorator text="{{ $member->group->welcome }}"></text-decorator>
                        @else
                            Welcome to the {{$member->group->name}} group. Feel free to explore your dashboard at any time. To access Member Profiles and Discussions, we will need for you to complete your Action Items. Would you like to start on that that now?
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-2 text-right" v-cloak>
                <post-request-link href="{{ action('Onboarding\StoreWelcomeController') }}">
                    <i class="fa fa-5x fa-chevron-circle-right"></i>
                </post-request-link>
            </div>
        </div>

        @include('onboarding._circles', ['current' => 1, 'total' => 5])
    </div>
@endsection