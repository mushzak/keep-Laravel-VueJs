<div class="card mb-3">
    <div class="card-header">
        Current action plan
    </div>
    <div class="card-body">
        <div><b>Ask</b></div>
        <p>{{ $member->lastCommitment->ask OR "Not Set" }}</p>

        <div><b>Backstory</b></div>
        <p>{{ $member->lastCommitment->backstory OR "Not Set"}}</p>

        <div><b>Commitment</b></div>
        <p>{{ $member->lastCommitment->name OR "Not Set"}}</p>

        <div><b>Status</b></div>
        <p>{{ $member->lastCommitment->outcome OR "Not Set"}}</p>
    </div>
</div>