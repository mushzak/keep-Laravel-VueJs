<?php

namespace App\Http\Controllers\GroupConfig;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreProfileController extends Controller
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
            'is_using_big_picture' => 'required|boolean',
            'is_using_personal_motivation' => 'required|boolean',
            'is_using_professional_background' => 'required|boolean',

            'vision_label' => 'required',
            'values_label' => 'required',
            'mission_label' => 'required',
            'why_label' => 'required',
            'consequences_label' => 'required',
            'company_name_label' => 'required',
            'company_bio_label' => 'required',
        ]);

        $group->update($input);

        auth()->user()->activeGroup->performAndResolve('group-updated-member-profile');

        return response([], 204);
    }
}
