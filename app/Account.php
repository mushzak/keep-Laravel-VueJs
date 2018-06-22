<?php

namespace App;

use App\Events\AccountCreated;
use App\Traits\Flaggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use Flaggable, SoftDeletes;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => AccountCreated::class,
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * An account will have many groups.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    /**
     * An account will be managed by a manager.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manager()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * An account has many members through groups.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HAsManyThrough
     */
    public function members()
    {
        return $this->hasManyThrough('App\Member', 'App\Group');
    } 


    /**
     * An account will have many users through groups.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasManyThrough
     */
    public function users()
    {
        return $this->hasManyThrough('App\User', 'App\Group');
    }  

}
