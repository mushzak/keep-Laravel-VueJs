@extends('layouts.app')

@section('title', 'Agreements - Group configuration')

@section('content')
    <div class="container">
        @include('groups.config._tabs', ['active' => 'agreements'])

        <edit-group-agreements-form :initial-group="{{ $group->toJson() }}"></edit-group-agreements-form>
    </div>
@endsection