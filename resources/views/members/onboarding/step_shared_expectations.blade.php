@extends('layouts.app')

@section('title', 'What To Expect')

@section('content')
    <div class="container">
        {{-- Breadcrumbs removed per Alan --}}
        {{--<ol class="breadcrumb">--}}
            {{--<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>--}}
            {{--<li class="breadcrumb-item"><a href="{{ route('groups.member-dashboard', $group->slug) }}">{{ $group->name }}</a></li>--}}
            {{--<li class="breadcrumb-item active">Analytics</li>--}}
        {{--</ol>--}}
        <div class="mb-4 row">
            <div class="mx-auto">
                <H2>Agreements</H2>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-2">
                <a href="{{ url("members/$member->id/onboarding/".($step-1)) }}" ><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a>
            </div>
            <div class="col-8 border p-3">
                drgegr aerg erag earg earg earg erg eg eg eg earg ergerg erg erg erg erg erg erg erg erg erg erg erg erg er
                erag erg WEf WEF wefwEF EFwef WERF wefsDFCV
                earg etgetertgWFWEFWef  wefwEF  Wef WEF 
                earg aerg Wef wEF WGF'I 
                erg wef EWEWfunpoun WEFIOJWerfoiWEFOUIHwrguoh  o[ihwEFOIH]
                earg earg earg earg erag erag 
            </div>

            <div class="col-2 col-2  text-right">
                <a href="{{ url("members/$member->id/onboarding/".($step+1)) }}" ><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-8 offset-2">
                <label for="password" class=" col-form-label">Password</label>
                <input class="form-control" type="password" name="password" id="password">
            </div>
        </div>

        <div class="row mt-4">
            <div class="mx-auto">
                <i class="fa fa-circle mr-1" aria-hidden="true"></i><i class="fa fa-circle mr-1" aria-hidden="true"></i><i class="fa fa-circle-o mr-1" aria-hidden="true"></i><i class="fa fa-circle mr-1" aria-hidden="true"></i><i class="fa fa-circle mr-1" aria-hidden="true"></i> 

            </div>
        </div>

    </div>
@endsection