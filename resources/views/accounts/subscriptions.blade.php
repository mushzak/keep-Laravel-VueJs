@extends('layouts.app')

@section('title', 'Subscription plan - Account management')

@section('content')
    <div class="container">
        @include('accounts._tabs', ['active' => 'subscriptions'])

        <edit-account-subscription-form :initial-account="{{ $account->toJson() }}"></edit-account-subscription-form>
    </div>
@endsection