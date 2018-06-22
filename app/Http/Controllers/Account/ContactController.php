<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $this->authorize('manage', auth()->user()->activeGroup);

        $account = auth()->user()->activeGroup->account;
        //Note: with('manager') on the above line returns all accounts)
        //The line below returns just the account of interest
        $account->load('manager');

        return view('accounts.contact', compact('account'));
    }
}
