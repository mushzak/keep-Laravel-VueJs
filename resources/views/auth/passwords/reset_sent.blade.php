@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-header">Email Sent to Reset Password</div>
                <div class="card-body">
                    <p>We sent you an email to reset your password. Click on the link in the email to reset your password.</p>

                    <div class="col-md-6 text-right">
                        <a href="{{route('home')}}" >
                            <button type="button" class="btn btn-primary">
                                OK
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
