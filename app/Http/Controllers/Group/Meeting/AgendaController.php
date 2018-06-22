<?php

namespace App\Http\Controllers\Group\Meeting;

use App\Agenda;
use App\Meeting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function index(Meeting $meeting)
    {
        $group = $meeting->group;

        $agendas = $meeting->agendas()->paginate();

        return view('groups.meetings.agendas.index', compact('group', 'meeting', 'agendas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function create(Meeting $meeting)
    {
        $this->authorize('facilitate', $meeting->group);

        $group = $meeting->group;

        return view('groups.meetings.agendas.create', compact('group', 'meeting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Meeting $meeting)
    {
        $this->authorize('facilitate', $meeting->group);

        $meeting->agendas()->create(
            $request->validate([
                'name' => 'required',
                'duration' => 'required|integer|min:1',
                'order' => [
                    'required',
                    'integer',
                    'min:1',
                    Rule::unique('agendas', 'order')->where('meeting_id', $meeting->id)
                ],
                'is_facilitator_only' => 'required|boolean',
            ])
        );

        flash()->success('The agenda item was created successfully.');
        return $this->route('meetings.agendas.index', $meeting->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Meeting  $meeting
     * @param  \App\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function edit(Meeting $meeting, Agenda $agenda)
    {
        $this->authorize('facilitate', $meeting->group);

        $group = $meeting->group;

        return view('groups.meetings.agendas.edit', compact('group', 'meeting', 'agenda'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meeting  $meeting
     * @param  \App\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meeting $meeting, Agenda $agenda)
    {
        $this->authorize('facilitate', $meeting->group);

        $agenda->update(
            $request->validate([
                'name' => 'required',
                'duration' => 'required|integer|min:1',
                'order' => [
                    'required',
                    'integer',
                    'min:1',
                    Rule::unique('agendas', 'order')->where('meeting_id', $meeting->id)->ignore($agenda->id)
                ],
                'is_facilitator_only' => 'required|boolean',
            ])
        );

        flash()->success('The agenda item was updated successfully.');
        return $this->route('meetings.agendas.index', $meeting->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meeting  $meeting
     * @param  \App\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meeting $meeting, Agenda $agenda)
    {
        $this->authorize('facilitate', $meeting->group);

        $agenda->delete();

        flash()->success('The agenda item was removed successfully.');
        return $this->route('meetings.agendas.index', $meeting->id);
    }
}
