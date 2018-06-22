<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreContactController extends Controller
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
            'name' => 'required',
            'business_name' => 'nullable',
            'phone' => 'nullable',
            'email' => 'nullable|email',
        ]);

        $account->update($input);

        $account->performAndResolve('account-updated-contact');

        return response([], 204);
    }
}
