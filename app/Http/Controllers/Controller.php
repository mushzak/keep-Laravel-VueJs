<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Generates a route to redirect the user to.
     *
     * @param $name
     * @param array $parameters
     * @param bool $absolute
     * @return string
     */
    protected function route($name, $parameters = [], $absolute = true)
    {
        $redirect = route($name, $parameters, $absolute);

        if (request()->wantsJson())
            return compact('redirect');

        return redirect($redirect);
    }
}
