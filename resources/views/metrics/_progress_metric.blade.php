<progress-chart :objectives="{{ $member->objectives->toJson() }}" :graph_only="{{ $graph_only ? 'true' : 'false' }}" :colors="['#80bf8e','#b7c1b9']"></progress-chart>

@if(isset($show_description) && $show_description )
	<hr>
	The path to achieving your goal is graphed above. As you complete objectives, you climb towards success. The staircase shows how many objectives are due each period, and green indicates completed objectives. If the green shaded area extends to the right of today, you are ahead of schedule!     
@endif
