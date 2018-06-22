<?php

namespace App\Listeners;

use App\Events\GroupCreating;

class MakeGroupSlugIfNoneExists
{
    /**
     * Handle the event.
     *
     * @param  GroupCreating  $event
     * @return void
     */
    public function handle(GroupCreating $event)
    {
        if (empty($event->group->slug))

            $event->group->slug = str_slug($event->group->name)
                                    . "-".rand(1000,9999);
    }
}
