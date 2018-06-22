<div class="card mb-3">
    <div class="card-header">Public</div>
    <div class="list-group list-group-flush">
        <a href="{{ route('groups.discussions.index', $group->slug) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
            @if($unreadGroupCount>0)
                <b class="should-be-bold">Group</b> <span class="badge badge-pill badge-secondary unread-group-message-count">{{$unreadGroupCount}}</span>
            @else
                <span class="should-be-bold">Group</span> <span class="badge badge-pill badge-secondary unread-group-message-count"></span>
            @endif 
        </a>
        <a href="{{ route('meetings.discussions.index', $group->slug) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
            Meetings
        </a>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header">Private</div>
    <div class="list-group list-group-flush">
        @foreach ($members as $member)
            <a href="{{ route('members.discussions.index', $member->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                @if ($member->unreadPrivateCount>0)
                    <b>{{ $member->user->name }}</b>
                @else
                    {{ $member->user->name }}
                @endif
            </a>
        @endforeach
    </div>
</div>