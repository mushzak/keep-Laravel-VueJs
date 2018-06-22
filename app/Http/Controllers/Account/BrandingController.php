<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandingController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $this->authorize('manage', auth()->user()->activeGroup);

        $account = auth()->user()->activeGroup->account;

        return view('accounts.branding', compact('account'));
    }
}
