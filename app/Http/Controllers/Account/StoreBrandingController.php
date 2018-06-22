<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StoreBrandingController extends Controller
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
            'use_custom_branding' => 'required|boolean',
            'custom_logo' => 'nullable|file',
        ]);

        $account->use_custom_branding = $input['use_custom_branding'];

        if ($request->file('custom_logo'))
            $account->custom_logo = Storage::disk('public')->putFile('custom_logo', $request->file('custom_logo'));

        $account->save();

        $account->performAndResolve('account-updated-branding');

        return response([], 204);
    }
}
