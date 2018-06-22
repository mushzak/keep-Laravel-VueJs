<?php

namespace App\Events;

use App\Meeting;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MeetingUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var Meeting */
    public $meeting;

    /**
     * Create a new event instance.
     *
     * @param Meeting $meeting
     */
    public function __construct(Meeting $meeting)
    {
        $this->meeting = $meeting;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("meetings.{$this->meeting->id}");
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'meeting' => $this->meeting->fresh()->load([
                'group' => function ($query) {
                    $query->select('id', 'name', 'slug', 'current_process');
                },
                'currentAgenda',
                'currentParticipant.member' => function ($query) {
                    $query->select('id', 'user_id', 'group_id');
                },
                'currentParticipant.member.user' => function ($query) {
                    $query->select('id', 'name');
                },
                'currentParticipant.member.group' => function ($query) {
                    $query->select('id', 'name', 'slug', 'current_process');
                },
                'currentParticipant.member.commitments',
                'currentParticipant.member.openFlags' => function ($query) {
                    $query->select('id', 'type');
                },
            ])
        ];
    }
}
