<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordForLoggedInController extends Controller
{
    /**
     * Send a password rest link.
     *
     * @return \Illuminate\Http\Response
     */
 	public function reset()
    {
		Password::sendResetLink(['email' => Auth::user()->email], function (Illuminate\Mail\Message $message) {
		    $message->subject('Your Password Reset Link');
		});
		//$this->tokens->create($auth()->user());
		

		return view('auth.passwords.reset_sent');
	}

}