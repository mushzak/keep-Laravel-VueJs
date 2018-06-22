<?php

namespace App;

use App\Events\ParticipantCreated;
use App\Events\ParticipantDeleted;
use App\Events\ParticipantUpdated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use SoftDeletes;

    const NOT_RESPONDED = 0;
    const ACCEPTED = 1;
    const REJECTED = 2;
    const MAYBE = 3;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ParticipantCreated::class,
        'deleted' => ParticipantDeleted::class,
        'updated' => ParticipantUpdated::class,
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    public $guarded = [];

    /**
     * A participant belongs to a member.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * A participant belongs to a meeting.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    /**
     * Returns the next participant that should have the floor for a meeting.
     *
     * @param Builder $query
     * @param Meeting|null $meeting
     * @return Builder
     */
    public function scopeNextForMeeting(Builder $query, ?Meeting $meeting)
    {
        $currentParticipantId = optional($meeting->currentParticipant)->id ?? 0;

        return $query
            ->where('id', '>', $currentParticipantId)
            ->where('is_present', true)
            ->orderBy('id');
    }

    /**
     * Returns the previous participant that had the floor for a meeting.
     *
     * @param Builder $query
     * @param Meeting|null $meeting
     * @return Builder
     */
    public function scopePreviousForMeeting(Builder $query, ?Meeting $meeting)
    {
        $currentParticipantId = optional($meeting->currentParticipant)->id ?? 0;

        return $query
            ->where('id', '<', $currentParticipantId)
            ->where('is_present', true)
            ->orderBy('id', 'desc');
    }
}
