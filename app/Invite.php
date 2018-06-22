<?php

namespace App;

use App\Events\InviteCreated;
use App\Events\InviteCreating;
use App\Events\InviteDeleted;
use App\Events\InviteUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\RoutesNotifications;

class Invite extends Model
{
    use RoutesNotifications, SoftDeletes;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'creating' => InviteCreating::class,
        'created' => InviteCreated::class,
        'updated' => InviteUpdated::class,
        'deleted' => InviteDeleted::class,
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * An invite will belong to a group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Returns an invite by its token, or null if none exists
     *
     * @param string $token
     * @return self|null
     */
    public static function findByToken (string $token)
    {
        return self::where('token', $token)->first();
    }

    public function confirm (User $user)
    {
        $member = Member::firstOrCreate([
            'user_id' => $user->id,
            'group_id' => $this->group_id,
        ]);

        if ($this->is_manager) {
            $member->group->update([
                'account_id' => $user->account->id,
            ]);
        }

        if ($this->is_facilitator) {
            $member->group->update([
                'facilitator_id' => $user->id,
            ]);
        }

        $this->delete();
    }
}
