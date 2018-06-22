<?php

namespace App\Http\Controllers\Member;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UpdatePersonalBackgroundController extends Controller
{
    /**
     * @param Request $request
     * @param Member $member
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Member $member)
    {
        $input = $request->validate([
            'personal_bio' => 'required',
            'personal_avatar' => 'nullable|image|max:512',
        ]);

        $member->personal_bio = $input['personal_bio'];

        if ($request->file('personal_avatar'))
            $member->personal_avatar = Storage::disk('public')->putFile('avatars', $request->file('personal_avatar'));

        $member->save();

        $member->performAndResolve('updated-personal-background');

        return response([], 204);
    }
}
