<effort-chart
        :completed.integer="{{ $member->commitments->sortByDesc('created_at')->take(10)->filter(function ($commitment) {
            return $commitment->completed();
        })->count() }}"
        :missed.integer="{{ $member->commitments->sortByDesc('created_at')->take(10)->filter(function ($commitment) {
            return $commitment->notCompleted();
        })->count() }}"
        :graph_only="{{ $graph_only ? 'true' : 'false' }}"

        :colors="['#80bf8e','#b7c1b9']">
</effort-chart>

@if(isset($show_description) && $show_description )
	<hr>
	The last 10 commitments are shown above. Commitments marked finish are counted as complete. Unfinished commitments are counted as incomplete after the next meeting.  

@endif