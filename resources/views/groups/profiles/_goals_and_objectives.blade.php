<div class="card mb-3">
    <div class="card-header">Goals and Objectives</div>
    <div class="card-body">
        @foreach ($member->goals as $goal)
            <p class="lead">{{ $goal->name }}</p>

            @if ($goal->objectives->count())
                <ul class="list-group">
                    @foreach ($goal->objectives as $objective)
                        <li class="list-group-item clearfix">
                            @if ($objective->completed_at)
                                <i class="fa fa-check"></i>
                            @else
                                <i class="fa fa-square-o"></i>
                            @endif

                            @if ($objective->is_blocked)
                                <del>{{ $objective->name }}</del>
                            @else
                                {{ $objective->name }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No objectives listed.</p>
            @endif
        @endforeach
    </div>
</div>