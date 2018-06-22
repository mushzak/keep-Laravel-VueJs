<?php

namespace App;

use App\Events\FlagCreated;
use App\Events\FlagUpdated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flag extends Model
{
    use SoftDeletes;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => FlagUpdated::class,
        'updated' => FlagUpdated::class,
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'resolved_at',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    public $guarded = [];

    /**
     * A flag belongs to something that can be flagged.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function flaggable()
    {
        return $this->morphTo();
    }

    /**
     * Only return unresolved flags.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActiveOnly(Builder $query)
    {
        return $query->whereNull('resolved_at');
    }

    /**
     * Generate a link for this flag based on what it is.
     *
     * @return string
     */
    public function link()
    {
        switch ($this->type) {
            case 'updated-action-plan':
                return route('groups.profiles.plan.edit', [$this->flaggable->group, $this->flaggable, '#update-action-plan']);
            case 'updated-personal-motivation':
                return route('groups.profiles.plan.edit', [$this->flaggable->group, $this->flaggable, '#update-personal-motivation']);
            case 'updated-big-picture':
                return route('groups.profiles.plan.edit', [$this->flaggable->group, $this->flaggable, '#update-big-picture']);
            case 'updated-goals-and-objectives':
                return route('groups.profiles.plan.edit', [$this->flaggable->group, $this->flaggable, '#update-goals-and-objectives']);
            case 'updated-personal-background':
                return route('groups.profiles.edit', [$this->flaggable->group, $this->flaggable, '#update-personal-background']);
            case 'updated-professional-background':
                return route('groups.profiles.edit', [$this->flaggable->group, $this->flaggable, '#update-professional-background']);
            case 'updated-contact-info':
                return route('groups.profiles.edit', [$this->flaggable->group, $this->flaggable, '#update-contact-info']);
            case 'updated-group-settings':
                return route('groups.config.about');
            case 'updated-account-settings':
                return route('accounts.index');
            case 'account-added-new-group' :
                return route('accounts.groups');
            case 'account-updated-subscription':
                return route('accounts.subscriptions');
            case 'account-updated-branding':
                return route('accounts.branding');
            case 'account-updated-contact':
                return route('accounts.contact');
            case 'account-updated-security':
                return route('accounts.security');
            case 'group-updated-expectations':
                return route('groups.config.about');
            case 'group-updated-agreements':
                return route('groups.config.agreements');
            case 'group-updated-feedback':
                return route('groups.config.feedback');
            case 'group-updated-check-ins':
                return route('groups.config.check-ins');
            case 'group-updated-member-plan':
                return route('groups.config.planning');
            case 'group-updated-member-profile':
                return route('groups.config.profiles');
            case 'group-updated-member-engagement':
                return route('groups.config.engagement');
            default:
                return '#';
        }
    }

}
