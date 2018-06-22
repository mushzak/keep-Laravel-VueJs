<?php

namespace App\Http\Controllers\Group;

use App\Group;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GiveFeedbackRedirectController extends Controller
{
    /**
     * Redirect to the first available member's give feedback page.
     *
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Group $group)
    {
        try {
            $member = $group->members()
                ->where('user_id', '!=', auth()->id())
                ->firstOrFail();
        }
        catch (ModelNotFoundException $exception)
        {
            return response()->view('groups.members.feedback.not-found', compact('group'), 404);
        }

        return redirect()->route('groups.members.give-feedback', [$group->slug, $member->id]);
    }
}
