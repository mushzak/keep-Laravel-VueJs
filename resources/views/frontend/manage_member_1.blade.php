@extends('layouts.app')

@section('title', "Manage People")

@section('content')
  <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h2>Manage People</h2>
        </div>
      </div>
      @foreach ($members as $member)
        <manage-member :member="{{$member->toJson()}}"></manage-member>
      @endforeach



  </div>
@endsection