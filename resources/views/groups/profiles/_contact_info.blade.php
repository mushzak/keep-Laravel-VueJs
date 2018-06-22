<div class="card mb-3">
    <div class="card-header">Contact information</div>
    <div class="card-body">
        <div><b>Email</b></div>
        <p>{{ $member->email }}</p>

        <div><b>Phone #1</b></div>
        <p>{{ $member->phone_1 }}</p>

        <div><b>Phone #2</b></div>
        <p>{{ $member->phone_2 }}</p>

        <div><b>Other POCs</b></div>
        <p>{{ $member->other }}</p>
    </div>
</div>