<?php

namespace App;

use App\Events\CommitmentCreated;
use App\Events\CommitmentDeleted;
use App\Events\CommitmentUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Commitment extends Model
{
    use SoftDeletes;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => CommitmentCreated::class,
        'updated' => CommitmentUpdated::class,
        'deleted' => CommitmentDeleted::class,
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    public $guarded = [];

    /**
     * A goal belongs to a member.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member ()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Mark this commitment as complete.
     *
     * @return $this
     */
    public function markAsComplete()
    {
        $this->completed_at = Carbon::now();

        return $this;
    }

    /**
     * Mark this commitment as incomplete.
     *
     * @return $this
     */
    public function markAsIncomplete()
    {
        $this->completed_at = null;

        return $this;
    }

    /**
     * Determines if this commitment has been completed.
     *
     * @return bool
     */
    public function completed()
    {
        return (bool) $this->completed_at;
    }

    /**
     * Determines if this commitment has been completed.
     *
     * @return bool
     */
    public function notCompleted()
    {
        return ! $this->completed();
    }
}
