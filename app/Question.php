<?php

namespace App;

use App\Events\QuestionCreated;
use App\Events\QuestionDeleted;
use App\Events\QuestionUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => QuestionCreated::class,
        'deleted' => QuestionDeleted::class,
        'updated' => QuestionUpdated::class,
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * An agreement belongs to a group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * A question has many feedback.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}
