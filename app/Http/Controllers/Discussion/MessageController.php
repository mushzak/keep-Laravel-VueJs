<?php

namespace App\Http\Controllers\Discussion;

use App\Member;
use App\Message;
use App\Channel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Channel $channel)
    {
        $member = Member::byGroupUser($channel->group, auth()->user())->firstOrFail();

        $input = $request->validate([
            'content' => 'required',
            'is_urgent' => 'required|boolean',
        ]);

        $channel->messages()->create([
            'author_id' => $member->id,
            'content' => $input['content'],
            'is_urgent' => $input['is_urgent'],
        ]);

        return response([], 204);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Channel  $channel
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Channel $channel, Message $message)
    {
        $message->update(
            $request->validate([
                'content' => 'required',
            ])
        );

        return response([], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Channel  $channel
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel, Message $message)
    {
        $message->delete();

        return response([], 204);
    }
}
