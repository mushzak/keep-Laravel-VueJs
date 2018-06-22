<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreGroupController extends Controller
{
    /**
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
            'facilitator_id' => ['required', Rule::exists('users', 'id')],
        ]);

        $account->groups()->create($input);

        $account->performAndResolve('account-added-new-group');

        return response([], 204);
    }
}
