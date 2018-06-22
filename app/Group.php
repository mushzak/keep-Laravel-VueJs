<?php

namespace App;

use App\Events\GroupCreated;
use App\Events\GroupCreating;
use App\Events\GroupDeleting;
use App\Events\GroupDeleted;
use App\Events\GroupUpdated;
use App\Traits\Flaggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use Flaggable, SoftDeletes;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'creating' => GroupCreating::class,
        'created' => GroupCreated::class,
        'updated' => GroupUpdated::class,
        'deleting' => GroupDeleting::class,
        'deleted' => GroupDeleted::class,
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * A group will belong to an account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * A group will belong to a single facilitator.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function facilitator()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A group will have many users belong to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'members','group_id','user_id');
    }

    /**
     * A group will have many members.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->hasMany(Member::class);
    }

    /**
     * A group will have a list of meetings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    /**
     * A group can have many discussions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function discussions()
    {
        return $this->morphMany(Discussion::class, 'target');
    }

    /**
     * A group can have many expectations set.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expectations()
    {
        return $this->hasMany(Expectation::class);
    }

    /**
     * A group can have many expectations set.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agreements()
    {
        return $this->hasMany(Agreement::class);
    }

    /**
     * A group can have many expectations set.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * A group will have been given much feedback.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function feedback()
    {
        return $this->hasManyThrough(Feedback::class, Question::class);
    }

    /**
     * A group will have many invites.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invites()
    {
        return $this->hasMany(Invite::class);
    }
}
