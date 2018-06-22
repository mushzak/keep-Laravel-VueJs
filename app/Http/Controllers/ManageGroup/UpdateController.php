<?php

namespace App\Http\Controllers\ManageGroup;

use App\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UpdateController extends Controller
{
    /**
     * @param Request $request
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Group $group)
    {
        $this->authorize('facilitate', $group);

        $input = $request->validate([
            'name' => 'required',
            'avatar' => 'nullable|image|max:512',
            'purpose' => 'nullable',
            'slogan' => 'nullable',
            'location' => 'nullable',
            'contact' => 'nullable',
            'description' => 'nullable',
        ]);

        $group->name = $request['name'];
        $group->purpose = $request['purpose'];
        $group->slogan = $request['slogan'];
        $group->location = $request['location'];
        $group->contact = $request['contact'];
        $group->description = $request['description'];

        if ($request->file('avatar'))
            $group->avatar = Storage::disk('public')->putFile('avatars', $request->file('avatar'));

        $group->save();

        flash()->success('Your group has been updated successfully.');
        $this->route('manage-group.edit', $group->slug);
    }
}
