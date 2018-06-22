<?php

namespace App\Http\Controllers\GroupConfig;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateFeedbackController extends Controller
{
    /**
     * Updates a group question.
     *
     * @param Request $request
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Question $question)
    {
        $this->authorize('facilitate', auth()->user()->activeGroup);

        $input = $request->validate([
            'content' => 'required',
            'when_asked' => 'required',
        ]);

        $question->update($input);

        auth()->user()->activeGroup->performAndResolve('group-updated-feedback');

        return response([], 204);
    }
}
