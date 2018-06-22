<span class="search-descussions-object" data-discussionSocketId="{{$discussion->id}}">
    <modal-discussion-thread :initial-discussion="{{ $discussion->toJson() }}" :members="{{ $members->toJson() }}" :group="{{ $group->toJson() }}" :facilitator-id="{{ $facilitatorId }}" :auth-user-id="{{ auth()->user()->id }}">
        <div class="mr-auto">
            @if (! in_array($discussion->id, array_flatten($list_read_discussions)))
                <div class="search-value" data-discussion="{{$discussion->id}}"><b>{{$discussion->title }}</b></div>
            @else
                <div class="search-value" data-discussion="{{$discussion->id}}">{{ $discussion->title }}</div>
            @endif
            <div class="text-muted small">
                @if ($discussion->author)
                    by {{ $discussion->author->user->name }}
                    &ndash;
                @endif
                <span data-replies_time="{{$discussion->id}}">{{(isset($discussion['replies'][count($discussion['replies'])-1]))? $discussion['replies'][count($discussion['replies'])-1]->created_at->diffForHumans() : $discussion->created_at->diffForHumans()}}</span>
            </div>
        </div>
        <div>
            <span class="text-muted small"><b data-replies_count="{{$discussion->id}}">{{ $discussion->replies_count }}</b> replies</span>
        </div>
    </modal-discussion-thread>
</span>