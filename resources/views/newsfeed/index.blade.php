@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @if (auth()->check())
            <div class="row">
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-header">Navigation
                        </div>
                        <ul class="list-group list-group-flush">
                            <a class="list-group-item" href="#">NewsFeed</a>
                            <a class="list-group-item" href="#">Journal</a>
                            <a class="list-group-item" href="#">Notifications
                                <div class="badge">2</div>
                            </a>
                            <a class="list-group-item" href="#">Strategic Planning</a>

                        </ul>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header"> {{auth()->user()->name}}'s Newsfeed

                            <a href="#" data-toggle="tooltip" data-placement="top" title="Goto Last Outcome"><i
                                        class="fa fa-trophy pull-right bg-primary" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Goto Last Commitment"><i
                                        class="fa fa-handshake-o pull-right bg-primary" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Goto Last Ask"><i
                                        class="fa fa-question-circle pull-right bg-primary" aria-hidden="true"></i></a>

                            <a href="#" data-toggle="tooltip" data-placement="top" title="Goto Last BackStory"> <i
                                        class="fa fa-book  pull-right bg-primary" aria-hidden="true"></i></a>
                            <div class="fa pull-right bg-primary">Goto Last:</div>

                            <a href="#" data-toggle="tooltip" data-placement="top" title="Goto Last Alert"> <i
                                        class="fa fa-exclamation-triangle  bg-primary" aria-hidden="true"> 2</i></a>


                        </div>
                        <div class="card-body">
                            <div class=" input-group">


                                <div class="input-group-btn">

                                    <button class=" btn btn-default " type="button">Comment</button>


                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false"><span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><i class="fa fa-trophy " aria-hidden="true"></i> Outcome</li>
                                        <li><i class="fa fa-handshake-o" aria-hidden="true"></i> Commitment</li>
                                        <li><i class="fa fa-question-circle " aria-hidden="true"></i> Ask</li>
                                        <li><i class="fa fa-book " aria-hidden="true"></i> Backstory</li>
                                        <li class="active"> Comment</li>

                                    </ul>
                                </div>

                                <input type="text" class="form-control" placeholder="new comment">
                                <span class="input-group-btn">
                                                <button class=" btn btn-default" type="button">Save</button>
                                </span>
                            </div>
                        </div>


                        <ul class="list-group list-group-flush">

                            <li class="list-group-item"><B>Nick:</B> Awesome!</li>
                            <li class="list-group-item list-group-item-info"><i class="fa fa-trophy"
                                                                                aria-hidden="true"></i> My new
                                product line just soldout
                            </li>
                            <li class="list-group-item"><B>Nick:</B> Did your new product work?</li>
                            <li class="list-group-item list-group-item-info"><i class="fa fa-handshake-o"
                                                                                aria-hidden="true"></i> Release
                                new design by August 4th
                            </li>
                            <li class="list-group-item"><B>Nick:</B> Why don't you commit to making a new design
                            </li>
                            <li class="list-group-item list-group-item-warning"><B>Me:</B> Last Christmas - It was
                                last year
                            </li>
                            <li class="list-group-item"><B>Nick:</B> When was your last piece of art?</li>
                            <li class="list-group-item list-group-item-danger"><i class="fa fa-exclamation-triangle"
                                                                                  aria-hidden="true"> </i> Review
                                Suzy's profile
                            </li>
                            <li class="list-group-item list-group-item-warning"><B>Me:</B> The ones that come into
                                the store look but bought
                                something last time
                            </li>
                            <li class="list-group-item"><B>Nick:</B> What do your customers say</li>
                            <li class="list-group-item list-group-item-info"><i class="fa fa-question-circle"
                                                                                aria-hidden="true"></i> My
                                product sales are down what should I do?
                            </li>
                            <li class="list-group-item list-group-item-info"><i
                                        class="fa fa-book" aria-hidden="true"></i> For the past several months my
                                sales have dipped. I have had promotions, and special events but sales are flat. I
                                am getting foot traffic but the sales are not occuring.
                            </li>
                            <li class="list-group-item list-group-item-danger"><i class="fa fa-exclamation-triangle"
                                                                                  aria-hidden="true"> </i> Business
                                Plan Objective is due
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">Journal
                        </div>
                        <div class="card-body">
                            <div class=" input-group">

                                <input type="text" class="form-control" placeholder="new journal entry">
                                <span class="input-group-btn">
                                                <button class=" btn btn-default" type="button">Save</button>
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

                    <div class="card">
                        <div class="card-header">Strategic Planning
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Achieve Break Even in Business</li>
                            <li class="list-group-item">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Grow Sales</li>
                                    <li class="list-group-item">Develop 2 Product Lines</li>
                                    <li class="list-group-item">Market new product</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
    </div>

    @else
        <p>Please <a href="{{ route('login') }}">log in</a> or <a href="{{ route('register') }}">register</a> to use
            this site.</p>
        @endif
        </div>
@endsection