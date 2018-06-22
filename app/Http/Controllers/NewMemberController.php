<?php

namespace App\Http\Controllers;

use App\Invite;
use Illuminate\Http\Request;

class NewMemberController extends Controller
{
    /**
     * @param $token
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function __invoke($token)
    {
        if (!$invite = Invite::findByToken($token)) {
            flash()->error('Your group invitation link has either expired or was otherwise invalid.');
            return redirect()->route('home');
        }

        return view('auth.new-member', compact('invite'));
    }
}
