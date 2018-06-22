<?php

namespace App;

use App\Events\MeetingCreated;
use App\Events\MeetingDeleted;
use App\Events\MeetingUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Meeting extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'was_facilitator_notified_of_unaccepted' => 'boolean',
        'was_participants_reminded' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'reminds_at',
        'starts_at',
        'started_at',
        'ends_at',
        'ended_at',
        'should_advance_at',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => MeetingCreated::class,
        'deleted' => MeetingDeleted::class,
        'updated' => MeetingUpdated::class,
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    public $guarded = [];

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format(Carbon::ATOM);
    }

    /**
     * This meeting belongs to a group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Each meeting can have a current agenda item that has the floor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currentAgenda()
    {
        return $this->belongsTo(Agenda::class, 'current_agenda_id');
    }

    /**
     * Each meeting can have a current participant that has the floor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currentParticipant()
    {
        return $this->belongsTo(Participant::class, 'current_participant_id');
    }

    /**
     * A meeting will have many participants.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    /**
     * A meeting will have many agenda items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agendas()
    {
        return $this->hasMany(Agenda::class);
    }

    /**
     * Many meetings will be attended by many members.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(Member::class, 'participants')->withTimestamps();
    }

    /**
     * A meeting will always have an associated discussion, and if not, one should be created.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne|\App\Discussion
     */
    public function discussion()
    {
        return $this->morphOne(Discussion::class, 'target');
    }

    /**
     * Returns a list of meetings where an unaccepted notification is needed.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMeetingParticipantNotificationNeeded($query)
    {
        return $query
            ->where('was_facilitator_notified_of_unaccepted', false)
            ->where('created_at', '<=', Carbon::now()->subWeek());
    }

    /**
     * Returns a list of meetings where a reminder notification is needed.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReminderNotificationNeeded($query)
    {
        return $query
            ->whereNotNull('reminds_at')
            ->where('reminds_at', '<=', Carbon::now())
            ->where('was_participants_reminded', false);
    }

    /**
     * Returns a count of all accepted participants
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithActiveParticipantCount($query)
    {
        return $query->withCount(['participants as active_participants_count' => function ($query) {
            return $query->where('status', Participant::ACCEPTED);
        }]);
    }

    /**
     * Returns a count of the total participants
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithTotalParticipantCount($query)
    {
        return $query->withCount(['participants as total_participants_count']);
    }

    /**
     * Syncs the participants table by a list of provided member ids.
     *
     * @param array $member_ids
     * @return $this
     */
    public function includeParticipants(array $member_ids)
    {
        // If the ID is not listed, it has been unchecked by the user and should be removed.
        $this->participants()->whereNotIn('member_id', $member_ids)->get()->each->delete();

        // Add the member to the meeting, but only if they have not already been included.
        foreach ($member_ids as $member_id)
            Participant::firstOrCreate([
                'meeting_id' => $this->id,
                'member_id' => $member_id,
            ]);
    }

    /**
     * Advance the meeting to the next item in the agenda.
     *
     * @return $this
     */
    public function advanceAgenda()
    {
        // If the meeting has previously ended, there's nothing further that can be done.
        if ($this->hasMeetingEnded())
            return $this;

        // If the current agenda item is open to group membership, we need to see if another member
        // wants to speak before attempting to move onto the next item on the agenda.
        if ($this->currentAgenda && !$this->currentAgenda->is_facilitator_only) {
            $nextParticipant = $this->participants()->nextForMeeting($this)->first();
        } else {
            $nextParticipant = null;
        }

        // If we were not successful getting the next member, it means we need to try to move onto
        // the next item in the agenda.
        if (!$nextParticipant) {
            $nextAgenda = $this->agendas()->nextForMeeting($this)->first();
        } else {
            // Since we were successful, we want to make sure the next agenda is also the current agenda.
            $nextAgenda = $this->currentAgenda;
        }

        // If the next agenda item is different from the current (meaning the agenda is about to change)
        // and the time is dedicated to the participants, the next participant will be the first
        // participant present.
        if ($nextAgenda && ($nextAgenda->id !== $this->current_agenda_id) && !$nextAgenda->is_facilitator_only) {
            $nextParticipant = $this->participants()->where('is_present', true)->first();
        }

        // If we were not successful getting a next agenda item OR a next participant, and the meeting
        // has been started previously, it means it is time to end the meeting.
        if (!$nextAgenda && !$nextParticipant && $this->hasMeetingStarted()) {
            $this->ended_at = Carbon::now();
            $this->current_agenda_id = null;
            $this->current_participant_id = null;
            $this->should_advance_at = null;

            return $this;
        }

        // If the meeting has not started, at this point, it should be started.
        if (!$this->hasMeetingStarted())
            $this->started_at = Carbon::now();

        // Set the next participant and next agenda item if we have the values to do so.
        $this->current_agenda_id = optional($nextAgenda)->id;
        $this->current_participant_id = optional($nextParticipant)->id;

        // Determine a soft deadline for advancing the meeting
        $this->calculateAdvanceAt($nextAgenda);

        return $this;
    }

    /**
     * Rollback the meeting to the previous item in the agenda.
     *
     * @return $this
     */
    public function rollbackAgenda()
    {
        // If the meeting has not started or ended, there's nothing further that can be done.
        if (!$this->hasMeetingStarted() && !$this->hasMeetingEnded())
            return $this;

        // If the current agenda item is open to group membership, we need to look back to see if a
        // previous member spoke before looking back for previous agenda items.
        if ($this->currentAgenda && !$this->currentAgenda->is_facilitator_only) {
            $previousParticipant = $this->participants()->previousForMeeting($this)->first();
        } else {
            $previousParticipant = null;
        }

        // If we were not successful getting the previous member, it means we need to try to move onto
        // the previous agenda item.
        if (!$previousParticipant) {
            $previousAgenda = $this->agendas()->previousForMeeting($this)->first();
        } else {
            // Since we were successful, we want to make sure the previous agenda is also the current agenda.
            $previousAgenda = $this->currentAgenda;
        }

        // If the previous agenda item is different from the current (meaning the agenda is about to change)
        // and the item is dedicated to the participants, the previous participant will be the last
        // participant present.
        if ($previousAgenda && ($previousAgenda->id !== $this->current_agenda_id) && !$previousAgenda->is_facilitator_only) {
            $previousParticipant = $this->participants()->where('is_present', true)->orderBy('id', 'desc')->first();
        }

        // If we were not successful getting a previous agenda item OR a previous participant, and the meeting
        // has started and not ended, we need to rollback the meeting from starting.
        if (!$previousAgenda && !$previousParticipant && $this->hasMeetingStarted() && !$this->hasMeetingEnded()) {
            $this->ended_at = null;
            $this->started_at = null;
            $this->current_agenda_id = null;
            $this->current_participant_id = null;
            $this->should_advance_at = null;

            return $this;
        }

        // If the meeting ended, at this point, it should be resurrected.
        if ($this->hasMeetingEnded()) {
            $this->ended_at = null;
        }

        // Set the previous participant and previous agenda item if we have the values to do so.
        $this->current_agenda_id = optional($previousAgenda)->id;
        $this->current_participant_id = optional($previousParticipant)->id;

        // Determine a soft deadline for advancing the meeting
        $this->calculateAdvanceAt($previousAgenda);

        return $this;
    }

    /**
     * Calculates and stores a timestamp by which the facilitator is suggested to move on with the meeting.
     *
     * @param Agenda|null $agenda
     * @return $this
     */
    public function calculateAdvanceAt(?Agenda $agenda)
    {
        // If no current agenda is set, then there is no recommendation possible.
        if (!$agenda) {
            $this->should_advance_at = null;

            return $this;
        }

        if ($agenda->is_facilitator_only) {
            // If this agenda item is only meant for the facilitator, add the time the facilitator
            // indicated they needed for this agenda item.
            $this->should_advance_at = Carbon::now()->addMinutes(
                $agenda->duration
            );
        } else {
            // If this agenda item is meant for the group, add the time the faciliator
            // indicated they needed for this agenda item, divided by the members present.
            $this->should_advance_at = Carbon::now()->addMinutes(
                (int)((float)$agenda->duration / (float)$this->participants()->count())
            );
        }

        return $this;
    }

    /**
     * Returns an integer of the difference between the start and end times of the meeting
     *
     * @return int
     */
    public function meetingTimeDelta()
    {
        return (int)$this->ends_at->diffInMinutes(
            $this->starts_at
        );
    }

    /**
     * Returns a string of the remaining time to schedule for this meeting.
     *
     * @return int
     */
    public function remainingTimeToSchedule()
    {
        return (int)$this->meetingTimeDelta() - $this->agendas->sum('duration');
    }

    /**
     * Returns true if the remaining time left to be budgeted is negative (and thereby overbudgeted)
     *
     * @return bool
     */
    public function isRemainingTimeNegative()
    {
        return $this->remainingTimeToSchedule() < 0;
    }

    /**
     * Determines if the meeting has started.
     *
     * @return bool
     */
    public function hasMeetingStarted()
    {
        return $this->started_at !== null;
    }

    /**
     * Determines if the meeting has ended.
     *
     * @return bool
     */
    public function hasMeetingEnded()
    {
        return $this->ended_at !== null;
    }


}
