<?php

namespace App\Http\Controllers\Group;

use App\Group;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GiveGuidanceRedirectController extends Controller
{
    /**
     * Redirect to the first available member's give guidance page.
     *
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Group $group)
    {
        try {
            $member = $group->members()->firstOrFail();
        }
        catch (ModelNotFoundException $exception)
        {
            return response()->view('groups.members.guidance.not-found', compact('group'), 404);
        }

        return redirect()->route('groups.members.give-guidance', [$group->slug, $member->id]);
    }

}
