<?php

namespace App\Http\Controllers\Group;

use App\Channel;
use App\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelController extends Controller
{
    /**
     * ChannelController constructor.
     */
    public function __construct()
    {
        $this->middleware('can:facilitate,group')->except(['index', 'show']);

        $this->middleware('can:participate,group');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function index(Group $group)
    {
        $channels = $group->channels()
            ->withCount('messages')
            ->orderBy('name')
            ->paginate();

        $members = $group->members()
            ->with('user')
            ->get();

        return view('groups.channels.index', compact('group', 'channels', 'members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function create(Group $group)
    {
        return view('groups.channels.create', compact('group'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Group $group)
    {
        $group->channels()->create(
            $request->validate([
                'name' => 'required'
            ])
        );

        flash()->success('The channel was created successfully.');
        return $this->route('groups.channels.index', $group->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group, Channel $channel)
    {
        $channel->messages = $channel->messages()
            ->with('author.user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('groups.channels.show', compact('group', 'channel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group, Channel $channel)
    {
        return view('groups.channels.edit', compact('group', 'channel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group, Channel $channel)
    {
        $channel->update(
            $request->validate([
                'name' => 'required',
                'is_archived' => 'required|boolean',
            ])
        );

        flash()->success('The channel was updated successfully.');
        return $this->route('groups.channels.index', $group->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @param  \App\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group, Channel $channel)
    {
        $channel->delete();

        flash()->success('The channel was deleted successfully.');
        return $this->route('groups.channels.index', $group->slug);
    }
}
