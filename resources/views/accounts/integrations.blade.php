@extends('layouts.app')

@section('title', 'Application integrations - Account management')

@section('content')
    <div class="container">
        @include('accounts._tabs', ['active' => 'integrations'])

        <edit-account-integrations-form :initial-account="{{ $account->toJson() }}"></edit-account-integrations-form>
    </div>
@endsection