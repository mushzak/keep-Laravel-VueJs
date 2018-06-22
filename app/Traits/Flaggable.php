<?php

namespace App\Traits;

use App\Action;
use App\Flag;
use Illuminate\Support\Carbon;

trait Flaggable
{
    /**
     * This model can be flagged.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function flags()
    {
        return $this->morphMany(Flag::class, 'flaggable');
    }

    /**
     * This model can have actions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function actions()
    {
        return $this->morphMany(Action::class, 'actionable');
    }

    /**
     * Perform an action and resolve any flags.
     *
     * @param string $type
     * @return $this
     */
    public function performAndResolve(string $type)
    {
        $this->performAction($type)->resolveFlags($type);

        return $this;
    }

    /**
     * Indicate that an action was performed
     *
     * @param string $type
     * @return $this
     */
    public function performAction(string $type)
    {
        $this->actions()->create(['type' => $type]);

        return $this;
    }

    /**
     * Resolve any flags with the type mentioned.
     *
     * @param string $type
     * @return $this
     */
    public function resolveFlags(string $type)
    {
        $flags=$this->flags()
            ->whereType($type)
            ->get();
        foreach($flags as $flag){
            $flag->update(['resolved_at' => Carbon::now()]);
        }
            // ->update(['resolved_at' => Carbon::now()]);
        // event(new \App\Events\FlagUpdated($this->flags()->whereType($type)->first()));

        return $this;
    }
}