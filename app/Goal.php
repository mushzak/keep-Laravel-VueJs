<?php

namespace App;

use App\Events\GoalCreated;
use App\Events\GoalDeleted;
use App\Events\GoalUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goal extends Model
{
    use SoftDeletes;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => GoalCreated::class,
        'updated' => GoalUpdated::class,
        'deleted' => GoalDeleted::class,
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
     * A goal has many objectives.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function objectives ()
    {
        return $this->hasMany(Objective::class)->orderBy('due_at', 'asc');
    }
}
