<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'duration' => 'integer',
        'is_facilitator_only' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    public $guarded = [];

    /**
     * Static model constructor
     */
    protected static function boot()
    {
        parent::boot();
    }

    /**
     * An agenda item belongs to a meeting.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    /**
     * Returns the next agenda for a meeting.
     *
     * @param Builder $query
     * @param Meeting|null $meeting
     * @return Builder
     */
    public function scopeNextForMeeting(Builder $query, ?Meeting $meeting)
    {
        $currentAgendaOrder = optional($meeting->currentAgenda)->order ?? 0;

        return $query->where('order', '>', $currentAgendaOrder);
    }

    /**
     * Returns the previous agenda for a meeting.
     *
     * @param Builder $query
     * @param Meeting|null $meeting
     * @return Builder
     */
    public function scopePreviousForMeeting(Builder $query, ?Meeting $meeting)
    {
        $currentAgendaOrder = optional($meeting->currentAgenda)->order ?? 0;

        return $query->where('order', '<', $currentAgendaOrder)->orderBy('order', 'desc');
    }
}
