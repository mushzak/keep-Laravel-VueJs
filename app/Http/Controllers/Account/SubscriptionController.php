<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $this->authorize('manage', auth()->user()->activeGroup);

        $account = auth()->user()->activeGroup->account;

        return view('accounts.subscriptions', compact('account'));
    }
}
