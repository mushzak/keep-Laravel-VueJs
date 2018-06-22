@extends('layouts.app')

@section('title', 'Security settings - Account management')

@section('content')
    <div class="container">
        @include('accounts._tabs', ['active' => 'security'])

        <edit-account-security-form :initial-account="{{ $account->toJson() }}"></edit-account-security-form>
    </div>
@endsection