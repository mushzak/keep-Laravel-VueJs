<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $this->authorize('manage', auth()->user()->activeGroup);

        $account = auth()->user()->activeGroup->account;
        //Note: with('groups') on the above line returns all accounts)
        //The line below returns just the account of interest
        $account->load('groups','members.user');

        return view('accounts.groups', compact('account'));
    }
}
