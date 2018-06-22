<?php

namespace App\Http\Controllers\Member;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class UpdateProfessionalBackgroundController extends Controller
{
    /**
     * @param Request $request
     * @param Member $member
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Member $member)
    {
        $input = $request->validate([
            'company_name' => 'required',
            'business_bio' => 'required',
            'business_avatar' => 'nullable|image|max:512',
        ]);

        $member->company_name = $input['company_name'];
        $member->business_bio = $input['business_bio'];

        if ($request->file('business_avatar'))
            $member->business_avatar = Storage::disk('public')->putFile('avatars', $request->file('business_avatar'));

        $member->save();

        $member->performAndResolve('updated-professional-background');

        return response([], 204);
    }
}
