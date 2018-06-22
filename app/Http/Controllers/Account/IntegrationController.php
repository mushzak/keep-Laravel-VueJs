<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IntegrationController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $account = auth()->user()->activeGroup->account;

        return view('accounts.integrations', compact('account'));
    }
}
