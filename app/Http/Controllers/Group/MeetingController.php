<?php

namespace App\Http\Controllers\Group;

use App\Group;
use App\Meeting;
use App\Http\Controllers\Controller;
use App\Rules\Datetime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function index(Group $group)
    {
        $this->authorize('index', [Meeting::class, $group]);

        $meetings = $group
            ->meetings()
            ->with('group.facilitator')
            ->withActiveParticipantCount()
            ->withTotalParticipantCount()
            ->orderBy('starts_at')
            ->paginate();

        return view('groups.meetings.index', compact('group', 'meetings'));
    }

    /**
     * Shows the form for scheduling a new meeting.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function create(Group $group)
    {
        $this->authorize('create', [Meeting::class, $group]);

        $members = $group->members()->with('user')->get();

        return view('groups.meetings.create', compact('group', 'members'));
    }

    /**
     * Stores a newly scheduled meeting.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Group $group)
    {
        $this->authorize('create', [Meeting::class, $group]);

        $input = $request->validate([
            'subject' => 'required',
            'starts_at' => ['required', new Datetime, 'after:now'],
            'ends_at' => ['required', new Datetime, 'after:starts_at'],
            'reminds_at' => ['nullable', new Datetime, 'after:now', 'before:starts_at'],
            'members' => 'required|array',
        ]);

        $meeting = Meeting::create([
            'group_id' => $group->id,
            'subject' => $input['subject'],
            'reminds_at' => $input['reminds_at'] ? Carbon::createFromTimeStampUTC(strtotime($input['reminds_at'])) : null,
            'starts_at' => Carbon::createFromTimeStampUTC(strtotime($input['starts_at'])),
            'ends_at' => Carbon::createFromTimeStampUTC(strtotime($input['ends_at'])),
        ]);

        $meeting->includeParticipants(array_keys(array_filter($request['members'])));

        flash()->success('The meeting was scheduled successfully.');
        return $this->route('groups.meetings.index', $group->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param Group $group
     * @param Meeting $meeting
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group, Meeting $meeting)
    {
        $this->authorize('view', $meeting);

        $meeting->load([
            'group',
            'currentAgenda',
            'currentParticipant.member.user',
            'currentParticipant.member.group',
            'currentParticipant.member.openFlags',
            'currentParticipant.member.commitments',
        ]);

        //members is loaded manually to reduce size and to pull all members of the group, not just in the discussion
        $meeting->members=\App\Member::where('group_id','=',$group->id)->select('group_id','id','user_id' )->get();        

        foreach($meeting->members as $member ){
            $member->load(['user' => function ($query) {
                $query->select ('id', 'name' );
            },]);
        };
          

        

        $meeting->participants = $meeting->participants()
            ->with('member.user')
            ->get();

        $meeting->discussion = $meeting->discussion()
           ->with(['author.user', 'replies.author.user'])
           ->first();

        return view('groups.meetings.show', compact('group', 'meeting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Group $group
     * @param Meeting $meeting
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group, Meeting $meeting)
    {
        $this->authorize('update', $meeting);

        $meeting->load('participants');

        $members = $group->members()->with('user')->get();

        return view('groups.meetings.edit', compact('group', 'meeting', 'members'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Group $group
     * @param Meeting $meeting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group, Meeting $meeting)
    {
        $this->authorize('update', $meeting);

        $input = $request->validate([
            'subject' => 'required',
            'starts_at' => ['required', new Datetime],
            'ends_at' => ['required', new Datetime, 'after:starts_at'],
            'reminds_at' => ['nullable', new Datetime, 'before:starts_at'],
            'members' => 'required|array',
        ]);

        $meeting->update([
            'subject' => $input['subject'],
            'reminds_at' => $input['reminds_at'] ? Carbon::createFromTimeStampUTC(strtotime($input['reminds_at'])) : null,
            'starts_at' => Carbon::createFromTimeStampUTC(strtotime($input['starts_at'])),
            'ends_at' => Carbon::createFromTimeStampUTC(strtotime($input['ends_at'])),
        ]);

        $meeting->includeParticipants(array_keys(array_filter($request['members'])));

        flash()->success('The meeting was updated successfully.');
        return $this->route('groups.meetings.index', $group->slug);
    }

    /**
     * Cancels a meeting.
     *
     * @param Group $group
     * @param Meeting $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group, Meeting $meeting)
    {
        $this->authorize('delete', $meeting);

        $meeting->delete();

        flash()->success('The meeting was cancelled successfully.');
        return $this->route('groups.meetings.index', $group->slug);
    }
}
