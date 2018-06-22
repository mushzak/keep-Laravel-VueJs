@extends('layouts.app')

@section('title', 'Account management')

@section('content')
    <div class="container">
        @include('accounts._tabs', ['active' => 'account'])

        <div class="row align-items-center">
            <div class="col-md">
                <h3 class="mr-5 text-center">
                    Account name: <br />
                    <b>{{ $account->name }}</b>
                </h3>
            </div>
            <div class="col-md">
                <div class="card mb-3">
                    <div class="card-header">
                        Action items
                    </div>
                    @if ($account->flags()->activeOnly()->count())
                        @foreach ($account->flags()->activeOnly()->get() as $flag)
                            <a href="{{ $flag->link() }}" class="list-group-item list-group-item-action">
                                {{ __("flags.{$flag->type}") }}
                            </a>
                        @endforeach
                    @else
                        <div class="card-body">
                            <p class="mb-0 lead text-center text-success">Nothing right now. Good job.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection