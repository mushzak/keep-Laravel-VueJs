<?php
/**
 * Created by PhpStorm.
 * User: Win10pro
 * Date: 5/4/2018
 * Time: 3:10 PM
 */

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $this->authorize('manage', auth()->user()->activeGroup);

        $account = auth()->user()->activeGroup->account;

        return view('accounts.notifications', compact('account'));
    }
}
