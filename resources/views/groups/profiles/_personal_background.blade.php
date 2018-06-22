<div class="card mb-3">
    <div class="card-header">Personal Background</div>
    <div class="card-body">
        <div><b>Name</b></div>
        <p>{{ $member->user->name }}</p>

        <div><b>Bio</b></div>
        <p>{{ $member->personal_bio }}</p>
    </div>
</div>