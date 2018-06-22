<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreSecurityController extends Controller
{
    /**
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        /** @var \App\Account $account */
        $account = auth()->user()->activeGroup->account;

        $this->authorize('manage', auth()->user()->activeGroup);

        $input = $request->validate([
            'is_using_2fa' => 'required|boolean',
        ]);

        $account->update($input);

        $account->performAndResolve('account-updated-security');

        return response([], 204);
    }
}
