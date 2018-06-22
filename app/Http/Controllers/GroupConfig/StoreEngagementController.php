<?php

namespace App\Http\Controllers\GroupConfig;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreEngagementController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        /** @var \App\Group $group */
        $group = auth()->user()->activeGroup;

        $this->authorize('facilitate', $group);

        $input = $request->validate([
            'default_notification_frequency' => 'required|in:immediately,daily',
            'default_notification_channel' => 'required|in:text,email',
        ]);

        $group->update($input);

        auth()->user()->activeGroup->performAndResolve('group-updated-member-engagement');

        return response([], 204);
    }
}
