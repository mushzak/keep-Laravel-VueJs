<?php

namespace App\Http\Controllers;

use App\Invite;
use App\User;
use Illuminate\Http\Request;

class StoreMemberController extends Controller
{
    /**
     * @param Request $request
     * @param $token
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function __invoke(Request $request, $token)
    {
        if (!$invite = Invite::findByToken($token)) {
            flash()->error('Your group invitation link has either expired or was otherwise invalid.');
            return redirect()->route('home');
        }

        $input = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        auth()->login(User::create($input));

        flash()->success('You have successfully joined the group.');
        return redirect()->route('onboarding');
    }
}
