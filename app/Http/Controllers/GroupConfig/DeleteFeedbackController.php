<?php

namespace App\Http\Controllers\GroupConfig;

use App\Question;
use App\Http\Controllers\Controller;

class DeleteFeedbackController extends Controller
{
    /**
     * Deletes a group question.
     *
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Question $question)
    {
        $this->authorize('facilitate', auth()->user()->activeGroup);

        $question->delete();

        auth()->user()->activeGroup->performAndResolve('group-updated-feedback');

        return response([], 204);
    }
}
