@extends('layouts.app')

@section('title', 'Group management - Account management')

@section('content')
    <div class="container">
        @include('accounts._tabs', ['active' => 'groups'])

        <edit-account-group-form :initial-account="{{ $account->toJson() }}"></edit-account-group-form>
    </div>
@endsection