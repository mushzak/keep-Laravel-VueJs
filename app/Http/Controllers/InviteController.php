<?php

namespace App\Http\Controllers;

use App\Invite;
use App\User;

class InviteController extends Controller
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

        if (auth()->check()) {
            $invite->confirm(auth()->user());
        }

        if (User::whereEmail($invite->email)->exists()) {
            flash()->success('You should log in to confirm your new group membership.');
            return redirect()->route('login');
        }

        flash()->success('You should register to confirm your new group membership.');
        return redirect()->route('new-member.index', $token);
    }
}
