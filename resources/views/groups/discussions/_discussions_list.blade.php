<div class="mb-3" v-cloak>
    @if ($discussions->count())
        <div class="list-group" id="search-descussions-object">
            <discussion-list :discussions="{{ $discussions->toJson() }}" :members="{{ $members->toJson() }}" :gotocommentdiscussionid="{{($goToCommentDiscussionId)?$goToCommentDiscussionId:0}}" :group="{{ $group->toJson() }}" :facilitator="{{ $facilitatorId }}" :auth="{{ auth()->user()->id }}" :flattened="{{ $list_read_discussions }}"></discussion-list>
        </div>
    @else
        <div class="card-body text-center">
            <p class="mb-0">
                There are no discussions here.
            </p>
        </div>
    @endif
</div>