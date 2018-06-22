@extends('layouts.app')

@section('title', 'Notification settings - Account management')

@section('content')
    <div class="container">
        @include('accounts._tabs', ['active' => 'notifications'])

        {{--<edit-account-security-form :initial-account="{{ $account->toJson() }}"></edit-account-security-form>--}}
        <edit-account-notifications-form :initial-account="{{ $account->toJson() }}"></edit-account-notifications-form>
    </div>
@endsection