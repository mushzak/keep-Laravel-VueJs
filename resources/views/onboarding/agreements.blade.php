@extends('layouts.app')

@section('title', 'Agreements - Onboarding')

@section('content')
    <div class="container">
        <div class="mb-3 d-flex">
            <div class="mx-auto">
                <h2>Agreements</h2>
            </div>
        </div>

        <form method="POST" action="{{ route('onboarding.agreements') }}">
            {{ csrf_field() }}

            <div class="row align-items-center mb-3">
                <div class="col-2 text-left">
                    <a href="{{ action('Onboarding\AboutController') }}">
                        <i class="fa fa-5x fa-chevron-circle-left"></i>
                    </a>
                </div>

                <div class="col-8">
                    <div class="card mb-3">
                        @if ($member->group->agreements->count())
                            <ul class="list-group list-group-flush">
                                @foreach ($member->group->agreements as $agreement)
                                    <li class="list-group-item" v-cloak>
                                        <text-decorator text="{{ $agreement->content }}"></text-decorator>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="card-body">
                                <p>You should talk to your group facilitator about the agreements set for your group.</p>
                                <p class="mb-0">You may continue once you have done so.</p>
                            </div>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label for="password">Enter Password as Electronic Signature</label>
                        <input type="password" class="form-control" id="password" name="password" />

                        @if ($errors->has('password'))
                            <div class="form-control-feedback">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                </div>

                <div class="col-2 text-right" v-cloak>
                    <button type="submit" class="btn btn-link" href="{{ action('Onboarding\StoreAgreementController') }}">
                        <i class="fa fa-5x fa-chevron-circle-right"></i>
                    </button>
                </div>
            </div>
        </form>

        @include('onboarding._circles', ['current' => 3, 'total' => 5])
    </div>
@endsection