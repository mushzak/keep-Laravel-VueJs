<?php

namespace App;

use App\Events\DiscussionCreated;
use App\Events\DiscussionDeleted;
use App\Events\DiscussionUpdated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Discussion extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_urgent' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'author_read_at',
        'target_read_at',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => DiscussionCreated::class,
        'updated' => DiscussionUpdated::class,
        'deleted' => DiscussionDeleted::class,
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format(Carbon::ATOM);
    }

    /**
     * A discussion will be sent to a variable target.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function target()
    {
        return $this->morphTo();
    }

    /**
     * A thread has many subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(DiscussionSubscription::class);
    }

    /**
     * A thread has many subscribers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'discussion_subscriptions');
    }

    /**
     * A discussion will belong to an author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Member::class, 'author_id');
    }

    /**
     * A discussion will have many replies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function beenReadBy()
    {
        return $this->belongsToMany(Member::class, 'acknowledgements')->withTimestamps();
    }


    /**
     * Return all discussions that either have been completely unread or have been unread
     * since new replies were added.
     *
     * @param Builder $query
     * @param \App\Member $member
     * @return Builder
     */
    public function scopeUnread(Builder $query, Member $member)
    {
        return $query
            // Include if a given discussion was never read.
            ->whereDoesntHave('beenReadBy', function($query2) use ($member){
                $query2->whereMemberId($member->id);
            })   

            // Include if a given discussions has replies that were created after a discussion was read
            ->orWhereExists(function ($query) use ($member) {
                $lastReplyCreatedAt = DB::raw('(select `created_at` from `replies` where `replies`.`discussion_id` = `discussions`.`id` order by `id` desc limit 1)');

                $query->selectRaw(1)
                    ->from('acknowledgements')
                    ->whereMemberId($member->id)
                    ->whereColumn('acknowledgements.discussion_id', 'discussions.id')
                    ->whereColumn($lastReplyCreatedAt, '>', 'acknowledgements.updated_at');
            })
            ;
    }

    /**
     * Eager load whether the given user subscribed to the discussion.
     *
     * @param $query
     * @param User|null $user
     * @return mixed
     */
    public function scopeWithHasUserSubscribed($query, ?User $user)
    {
        if (is_null($user))
            return $query;

        $query->withCount(['subscriptions AS has_user_subscribed' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }]);
    }

    /**
     * Have the user subscribe the model.
     *
     * @param User $user
     */
    public function subscribe(User $user)
    {
        $this->subscribers()->syncWithoutDetaching($user->id);
    }

    /**
     * Have the user unsubscribe the model.
     *
     * @param User $user
     */
    public function unsubscribe(User $user)
    {
        $this->subscribers()->detach($user->id);
    }

}
