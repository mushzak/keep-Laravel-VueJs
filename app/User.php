<?php

namespace App;

use App\Events\AccountCreated;
use App\Events\UserCreated;
use App\Events\UserUpdated;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'bool',
        'should_not_notify' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'last_checked_in_at',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => UserCreated::class,
        'updated' => UserUpdated::class,
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Each user might have a single account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->hasOne(Account::class, 'manager_id');
    }

    /**
     * A user will belong to many groups.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'members', 'user_id', 'group_id');
    }

    /**
     * A user may have an active group set.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activeGroup()
    {
        return $this->belongsTo(Group::class, 'active_group_id');
    }

    /**
     * A user can facilitate many groups.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function facilitating()
    {
        return $this->hasMany(Group::class, 'facilitator_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goals()
    {
        return $this->hasMany(Goal::class, 'owner');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function issues()
    {
        return $this->hasMany(Issue::class, 'owner');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actions()
    {
        return $this->hasMany(Action::class, 'owner');
    }

    /**
     * A user has many memberships.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany(Member::class);
    }

    /**
     * A user may be a member of the activeGroup.
     *
     * @return member
     */
    public function activeGroupMember()
    {
        return $this->hasOne(Member::class)->where('group_id', $this->active_group_id);
    }

    /**
     * Automatically hash the password if one is being set.
     *
     * This allows us to blindly throw passwords into this model and provides a centralized
     * location for changing the hashing function later.
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        if ($value !== null) {
            $this->attributes['password'] = bcrypt($value);
        }
    }
}
