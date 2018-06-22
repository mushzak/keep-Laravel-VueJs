@extends('layouts.app')

@section('title', 'Check-ins - Group configuration')

@section('content')
    <div class="container">
        @include('groups.config._tabs', ['active' => 'check-ins'])

        <finish-process-form :group="{{ $group->toJson() }}"></finish-process-form>

        <div class="card mb-3">
            <div class="card-header">
                Check-in settings
            </div>
            <div class="card-body">
                <edit-group-check-ins-form :initial-group="{{ $group->toJson() }}"></edit-group-check-ins-form>
            </div>
        </div>
    </div>
@endsection