<?php

namespace App;

use App\Events\ObjectiveCreated;
use App\Events\ObjectiveDeleted;
use App\Events\ObjectiveUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Objective extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'completed_at',
        'due_at',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ObjectiveCreated::class,
        'updated' => ObjectiveUpdated::class,
        'deleted' => ObjectiveDeleted::class,
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
     * An objective belongs to a goal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    /**
     * Mark this objective as complete.
     *
     * @return $this
     */
    public function markAsComplete()
    {
        $this->completed_at = Carbon::now();

        return $this;
    }

    /**
     * Mark this objective as incomplete.
     *
     * @return $this
     */
    public function markAsIncomplete()
    {
        $this->completed_at = null;

        return $this;
    }

    /**
     * Determines if this objective has been completed.
     *
     * @return bool
     */
    public function completed()
    {
        return (bool) $this->completed_at;
    }

    /**
     * Determines if this objective has been completed.
     *
     * @return bool
     */
    public function notCompleted()
    {
        return ! $this->completed();
    }
}
