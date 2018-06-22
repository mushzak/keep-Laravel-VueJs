<?php

namespace App;

use App\Events\MessageCreated;
use App\Events\MessageDeleted;
use App\Events\MessageUpdated;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class Message
 *
 * @deprecated
 */
class Message extends Model
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
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => MessageCreated::class,
        'updated' => MessageUpdated::class,
        'deleted' => MessageDeleted::class,
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
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format(Carbon::ATOM);
    }

    /**
     * A message will be sent to a variable entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function messageable()
    {
        return $this->morphTo();
    }

    /**
     * A message will always belong to an author, who composed the message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Member::class, 'author_id');
    }

    public function scopeSentBy(Builder $query, Member $member)
    {
        return $query
            ->where('author_id', $member->id);
    }

    public function scopeSentTo(Builder $query, Model $model)
    {
        return $query
            ->where('messageable_id', $model->id)
            ->where('messageable_type', get_class($model));
    }

    public function scopeSentOrReceivedBy(Builder $query, Model $model)
    {
        if ($model instanceof Member)
            $query = $query->orWhere(function ($query) use ($model) {
                return $query->sentBy($model);
            });

        return $query->orWhere(function ($query) use ($model) {
            return $query->sentTo($model);
        });
    }
}
