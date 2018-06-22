@extends('layouts.app')

@section('title', 'What We Are About - Onboarding')

@section('content')
    <div class="container">
        <div class="mb-3 d-flex">
            <div class="mx-auto">
                <h2>What We Are About</h2>
            </div>
        </div>

        <div class="row align-items-center mb-3">
            <div class="col-2 text-left">
                <a href="{{ action('Onboarding\WelcomeController') }}">
                    <i class="fa fa-5x fa-chevron-circle-left"></i>
                </a>
            </div>

            <div class="col-8">
                <div class="card">
                    @if ($member->group->expectations->count())
                        <ul class="list-group list-group-flush">
                            @foreach ($member->group->expectations as $expectation)
                                <li class="list-group-item" v-cloak>
                                    <text-decorator text="{{ $expectation->content }}"></text-decorator>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="card-body">
                            <p>You should talk to your group facilitator about the expectations set for your group.</p>
                            <p class="mb-0">You may continue once you have done so.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-2 text-right" v-cloak>
                <post-request-link href="{{ action('Onboarding\StoreAboutController') }}">
                    <i class="fa fa-5x fa-chevron-circle-right"></i>
                </post-request-link>
            </div>
        </div>

        @include('onboarding._circles', ['current' => 2, 'total' => 5])
    </div>
@endsection