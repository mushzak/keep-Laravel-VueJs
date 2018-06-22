<?php

namespace App\Http\Controllers\Discussion;

use App\Discussion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscribeController extends Controller
{
    /**
     * Adds or removes the authenticated user from the subscription.
     *
     * @param Request $request
     * @param Discussion $discussion
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Discussion $discussion)
    {
        $exists = $discussion->subscriptions()
            ->whereUserId($request->user()->id)
            ->exists();

        if ($exists) {
            $discussion->unsubscribe($request->user());
        }
        else {
            $discussion->subscribe($request->user());
        }

        return response([], 204);
    }
}
