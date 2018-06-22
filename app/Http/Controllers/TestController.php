<?php

namespace App\Http\Controllers;

use App\Mail\SendTestComment;
use App\Mail\SendTestCommentConfirm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Test;



class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = \App\Test::orderBy('created_at','desc')->get();
        return view('test_comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $comment_uri= $request->get('comment_uri');
        return view('test_comments.create', compact('comment_uri'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment=new \App\Test;
        $comment->uri= $request->get('comment_uri');
        $comment->comment=$request->get('comment');
        $comment->status='Unanswered';
        $comment->user_id=\Auth::user()->id;
        $comment->save();
//        $user_tester=\App\User::where('email','=', 'dmh@ejcinc.com')->first();
//        $user_tester=\App\User::where('email','=', 'alan@keepical.com')->first();
        $user_author=\App\User::find($comment->user_id);

        Mail::to('alan@keepical.com')->send(new SendTestComment($comment));
        Mail::to($user_author)->send(new SendTestCommentConfirm($comment));
        return redirect('/tests');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Test $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Test $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Test $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        $test->uri= $request->get('comment_uri');
        $test->comment=$request->get('comment');
        $test->response=$request->get('response');
        $test->status=$request->get('status');
        $test->save();
        return redirect('/tests');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Test $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        //
    }

}