@extends('layouts.app')

@section('title', 'Branding - Account management')

@section('content')
    <div class="container">
        @include('accounts._tabs', ['active' => 'branding'])

        <edit-account-branding-form :initial-account="{{ $account->toJson() }}"></edit-account-branding-form>
    </div>
@endsection