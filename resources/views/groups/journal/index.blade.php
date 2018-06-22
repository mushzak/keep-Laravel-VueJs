@extends('layouts.app')

@section('title', "Journal")

@section('content')
    <div class="container-fluid">
        @include('groups._groupmenu')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Journal</div>
                <div class="card-body">
                    <div class="form-group">
                        <textarea class="form-control" class="form-control" id="text" name="text" placeholder="Text">{{ old('text') }}</textarea>
                    </div>

                    <div class="input-group">
                        <input type="date" class="form-control" id="date" name="date" placeholder="Date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') ?? old('date') }}" />

                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default form-control" type="button">Save</button>
                        </span>
                    </div>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><B>11/27:</B> Reordered Parts</li>
                    <li class="list-group-item"><B>11/26:</B> Began Sales of new product</li>
                    <li class="list-group-item"><B>11/25:</B> Setup new product in POS</li>
                    <li class="list-group-item"><B>11/24:</B> Called customers about new product</li>
                    <li class="list-group-item"><B>11/23:</B> Designed marketing material</li>
                    <li class="list-group-item"><B>11/22:</B> Made patch run of products</li>
                    <li class="list-group-item"><B>11/21:</B> Began design of new product</li>
                </ul>
            </div>
        </div>
    </div>
@endsection