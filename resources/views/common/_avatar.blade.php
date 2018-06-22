<a href="{{ route('groups.profiles.show', [$member->group->slug, $member->id]) }}">
    @if ($member->personal_avatar)
        <img src="{{ Storage::url($member->personal_avatar) }}"
             alt="{{ $member->user->name }}"
             class="img-thumbnail rounded-circle mb-3"/>
    @else
        <div class="img-thumbnail rounded-circle mx-auto d-flex flex-column justify-content-center mb-3"
             style="width: 150px; height: 150px">
            <span class="fa fa-5x fa-user"></span>
        </div>
    @endif
</a>