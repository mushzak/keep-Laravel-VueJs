<footer class="pt-2 pb-2 d-print-none">
    <div class="container">
        <div class="row align-items-center text-sm-right text-center ">
            <div class="col-md col-sm-6 text-sm-left">

                <h3 class="mb-2 brand-font"><img class="logo-keepical" src="{{asset('images/keepical_wordlogo.png')}}"></h3>

                {{--<p class="text-info">Mastermind meetings made <i>simple</i>.</p>--}}
                <p class="text-info">Keeping groups together.</p>
            </div>
            <div class="col-md col-sm-6">
{{--                 <h5>Services</h5>
                <ul class="nav flex-column mb-3">
                    <li class="nav-item">
                        <a class="nav-link p-0 mb-1" href="#">About Gantry</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-0 mb-1" href="#">FAQs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-0 mb-1" href="#">Pricing</a>
                    </li>
                </ul> --}}
            </div>
            <div class="col-md col-sm-6">
                <h5>Support</h5>
                <ul class="nav flex-column mb-3">
{{--                     <li class="nav-item">
                        <a class="nav-link p-0 mb-1" href="#">Contact us</a>
                    </li> --}}
                    <li class="nav-item">
                            <form id="form-tests" action="/tests/create" method="POST">
                                    <input type="hidden" name="_method" value="GET">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="comment_uri" value="{{Request::path()}}">


                            </form>
                            <a class="nav-link p-0 mb-1" href=""
                               onclick="event.preventDefault();
                                                 document.getElementById('form-tests').submit();">
                                Report an Issue
                            </a>

                    </li>
{{--                     <li class="nav-item">
                        <a class="nav-link p-0 mb-1" href="#">Affiliate program</a>
                    </li> --}}
                </ul>
            </div>
{{--             <div class="col-md col-sm-6">
                <h5>Legal</h5>
                <ul class="nav flex-column mb-3">
                    <li class="nav-item">
                        <a class="nav-link p-0 mb-1" href="#">Privacy policy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-0 mb-1" href="#">Refund policy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-0 mb-1" href="#">Terms of service</a>
                    </li>
                </ul>
            </div> --}}
            {{-- <div class="col-md col-sm-6"> --}}
                {{--<h5>Contact</h5>--}}
                {{--<ul class="nav flex-column mb-3">--}}
                    {{--<li class="nav-item">--}}
                        {{--+ 1 (800) 555-1212--}}
                    {{--</li>--}}
                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link p-0 mb-1" href="#">support@gantry.com</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        </div>
        <p class="text-muted">
            {{--&copy; 2016 - {{ date('Y') }} Alan Derrick.  All rights reserved.--}}
        </p>
    </div>
</footer>