<?php

namespace App;

use App\Events\ExpectationCreated;
use App\Events\ExpectationDeleted;
use App\Events\ExpectationUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expectation extends Model
{
    use SoftDeletes;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ExpectationCreated::class,
        'deleted' => ExpectationDeleted::class,
        'updated' => ExpectationUpdated::class,
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * An expectation belongs to a group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
