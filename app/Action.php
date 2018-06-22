<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Action extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    public $guarded = [];

    /**
     * A action belongs to something that commit actions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function actionable()
    {
        return $this->morphTo();
    }

    /**
     * Static model constructor
     */
    protected static function boot()
    {
        parent::boot();

        // Always order from newest to oldest.
        // When we pull the first action of a member's stack of actions, we will almost always
        // want to know the last time a member did a particular thing.
        static::addGlobalScope('order', function (Builder $builder) {
            $builder
                ->orderBy('created_at', 'desc')
                ->orderBy('id', 'desc');
        });
    }
}
