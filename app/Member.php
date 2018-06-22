<?php

namespace App;

use App\Events\MemberCreated;
use App\Events\MemberUpdated;
use App\Events\MemberDeleting;
use App\Traits\Flaggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Member extends Model
{
    use Flaggable, SoftDeletes;

    // Determines the member's onboarding step.
    const ONBOARDED = 0;
    const ONBOARDING_VERIFY = 1;
    const ONBOARDING_WELCOME = 2;
    const ONBOARDING_ABOUT = 3;
    const ONBOARDING_AGREEMENTS = 4;
    const ONBOARDING_EXPECTATIONS = 5;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => MemberCreated::class,
        'updated' => MemberUpdated::class,
        'deleted' => MemberDeleting::class,
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    public $guarded = [];

    /**
     * A membership belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A membership belongs to a group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * A membership will have many feedbacks.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * A member will have many goals.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    /**
     * A member will have many objectives through their goals.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function objectives()
    {
        return $this->hasManyThrough(Objective::class, Goal::class);
    }

    /**
     * A member will have many completed objectives.
     *
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function completedObjectives()
    {
        return $this->hasManyThrough(Objective::class, Goal::class)
            ->whereNotNull('completed_at');
    }

    /**
     * A member will have many commitments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commitments()
    {
        return $this->hasMany(Commitment::class);
    }

    /**
     * A member will have many completed commitments.
     *
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function completedCommitments()
    {
        return $this->hasMany(Commitment::class)
            ->whereNotNull('completed_at');
    }

    /**
     * A member may have one last commitment which represents their current
     * commitment.
     *
     * @return \Illuminate\Database\Schema\Builder
     */
    public function lastCommitment()
    {
        return $this->hasOne(Commitment::class)->orderBy('id', 'desc');
    }

    /**
     * A member may have one last commitment which represents their current
     * commitment.
     *
     * @return \Illuminate\Database\Schema\Builder
     */
    public function lastGoal()
    {
        return $this->hasOne(Goal::class)->orderBy('id', 'desc');
    }

    /**
     * A member can be the sender of many messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussionsSent()
    {
        return $this->hasMany(Discussion::class, 'author_id');
    }

    /**
     * A member can be the recipient of many messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function discussionsReceived()
    {
        return $this->morphMany(Discussion::class, 'target');
    }

    /**
     * A member may have read many messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function discussionsRead()
    {
        return $this->belongsToMany(Discussion::class, 'acknowledgements');
    }

    /**
     * A member can be the sender of many replies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function repliesSent()
    {
        return $this->hasMany(Reply::class, 'author_id');
    }

    /**
     * A member can have made many feedback.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * A member can have many flags.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function flags()
    {
        return $this->morphMany('App\Flag','flaggable');
    }

 
    /**
     * A member can have many flags that are open.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function openFlags()
    {
        return $this->morphMany('App\Flag','flaggable')->where('resolved_at','=',null);
    }

    /**
     * A member will have many meetings through their Participant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function meetings()
    {
        return $this->belongsToMany(Meeting::class, 'participants');
    }

    /**
     * Return a Member by if it has a flag of particular type.
     *
     * @param Builder $query
     * @param string $type
     * @return Builder
     */
    public function scopeHasFlagType(Builder $query, $type)
    {
        return $query
            ->whereHas('flags', function (Builder $query) use ($type){
                $query
                    ->whereNull('resolved_at')
                    ->where('type','=', $type);
            });
    }


    /**
     * Return a Member by its Group and User.
     *
     * @param Builder $query
     * @param Group $group
     * @param User $user
     * @return Builder
     */
    public function scopeByGroupUser($query, Group $group, User $user)
    {
        return $query
            ->whereGroupId($group->id)
            ->whereUserId($user->id)
            ->whereNotNull('group_id')
            ->whereNotNull('user_id')
            ->with('user');
    }

    /**
     * Return a list of members who are late for their check-in.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeLateForCheckIn(Builder $query)
    {
        return $query
            ->join('groups', 'groups.id', '=', 'members.group_id')
            ->addSelect('members.*', 'groups.check_in_interval as check_in_interval')
            ->whereHas('group', function (Builder $query) {
                // The check in interval for a member's group should never be 0, because
                // that implies that the functionality was disabled.
                $query->where('check_in_interval', '!=', 0);
            })
            ->whereHas('user', function (Builder $query) {
                $query
                    // Include if the user's (last check in date + the number of days they had to check in again) < right now.
                    ->where(DB::raw('DATE_ADD(`last_checked_in_at`, INTERVAL `check_in_interval` DAY)'), '<', Carbon::now())

                    // If the user has never used their account, that counts as being late.
                    ->orWhereNull('last_checked_in_at');
            });
    }


    /**
     * Return a list of members who have not affirmed their plan
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeUnaffirmedActionPlan(Builder $query)
    {
        return $query
            ->whereHas('flags', function (Builder $query) {
                return $query->where('type','=','updated-action-plan')
                        ->whereNull('resolved_at');
            });
    }

    /**
     * Return a list of members who have a meeting in 2 days
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeUpcomingMeeting(Builder $query)
    {        
        return $query
            ->whereHas('meetings', function (Builder $query) {
                $now=\Carbon\Carbon::now();
                $now2days=\Carbon\Carbon::now()->addDays(2);
                return $query
                            ->whereNull('ended_at')
                            ->whereDate('starts_at','>',$now)
                            ->whereDate('starts_at','<',$now2days)
                            ;
            });
    }

    /**
     * Returns the predictor metric
     *
     * @return int
     */
    public function predictorMetric()
    {
        $completedCommitments = $this->commitments->filter(function ($commitment) {
            return $commitment->completed();
        })->count();

        $totalCommitments = $this->commitments->count();

        if ($totalCommitments < 10) {
            $completedCommitmentsAdjusted = 10 - ($totalCommitments - $completedCommitments);
            $totalCommitmentsAdjusted = 10;
        } else {
            $completedCommitmentsAdjusted = $completedCommitments;
            $totalCommitmentsAdjusted = $totalCommitments;
        }

        $commitmentFactor = $completedCommitmentsAdjusted / $totalCommitmentsAdjusted;

        $completedObjectives = $this->objectives->filter(function ($objectives) {
            return $objectives->completed();
        })->count();

        $dueObjectives = $this->objectives->where('due_at', '<=', date('Y-m-d'))->count();

        $objectiveFactor = max($completedObjectives, 1) / max($dueObjectives, 1);

        $modifier = 0.5;

        return min((($modifier * $objectiveFactor) + (1 - $modifier) * $commitmentFactor) * 100, 100);
    }

    /**
     * Returns a class based on the predictor bar length.
     *
     * @return string
     */
    public function predictorBarClassMetric()
    {
        switch ($predictor = $this->predictorMetric()) {
            case $predictor > 0:
                return 'bg-success';
            case $predictor > -1:
                return 'bg-warning';
            default:
                return 'bg-danger';
        }
    }
}
