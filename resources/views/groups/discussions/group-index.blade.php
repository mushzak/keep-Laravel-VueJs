@extends('layouts.app')

@section('title', 'Group Discussions')

@section('content')
    <div class="container position-relative">
        <div class="row">

            <div class="col-md-4 col-xs-12 position-relative z-index-555">
                <div class="position-fixed-custom position-fixed-response-none width-div-custom">
                    <h1 class="mb-3">Group Discussions</h1>
                    <input class="form-control" id="search-description" type="text" placeholder="Search" onkeyup="myFunction()">
                    <br>
                    <div class="order-md-first">
                        @include('groups.discussions._discussions_menu')
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-md-offset-4 col-xs-12 disc-col">
                <div class="col disc-col">
                    <div class="position-relative-custom height-custom-50 dis-block">
                        <div class="position-absolute-custom position-absolute-custom-style position-absolute-response-none">
                            <div class="d-flex mb-3 position-fixed-custom position-fixed-response-none">
                                <div class="position-relative">
                                    <div class="ml-auto">
                                        <a href="{{ route('groups.discussions.create', [$group->slug]) }}" class="btn btn-secondary">
                                            <i class="fa fa-plus" aria-hidden="true"></i> new group discussion
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="position-relative">
                        <div class="position-relative  disc-list">
                            @include('groups.discussions._discussions_list')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function myFunction() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("search-description");
        filter = input.value.toUpperCase();
        table = document.getElementById("search-descussions-object");
        tr = table.getElementsByClassName("search-value");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].innerText;
            if (td) {
                if (td.toUpperCase().indexOf(filter) > -1) {
                    tr[i].parentElement.parentElement.parentElement.parentElement.style.display = "";
                } else {
                    tr[i].parentElement.parentElement.parentElement.parentElement.style.display = "none";
                }
            }
        }
    }
</script>