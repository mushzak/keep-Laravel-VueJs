<?php
/**
 * Created by PhpStorm.
 * User: Win10pro
 * Date: 5/4/2018
 * Time: 6:14 PM
 */

namespace App\Http\Controllers\Account;

use App\Group;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UpdateNotificationsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $input = $request->all();
//        dd($input);
//        $notification->update($input);

        return response([], 204);
    }
}


