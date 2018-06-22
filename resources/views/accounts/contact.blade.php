@extends('layouts.app')

@section('title', 'Contact information - Account management')

@section('content')
    <div class="container">
        @include('accounts._tabs', ['active' => 'contact'])

        <edit-account-contact-form :initial-account="{{ $account->toJson() }}"></edit-account-contact-form>
    </div>
@endsection