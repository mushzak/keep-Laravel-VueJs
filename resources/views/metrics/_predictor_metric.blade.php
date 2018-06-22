<div class="progress">
    <div class="progress-bar progress-bar-striped {{ $member->predictorBarClassMetric() }}"
         role="progressbar"
         style="width: {{ $member->predictorMetric() }}%"
         aria-valuenow="{{ $member->predictorMetric() }}"
         aria-valuemin="0"
         aria-valuemax="100"></div>
</div>

@if(isset($show_description) && $show_description )
	<hr>
	<b>Predictor </b>= (Objective Factor +  Commitment Factor) / 2
    <br><b>Objective Factor </b>= Completed Objectives / Objectives Due
    <br><b>Commitment Factor </b>= Completed Commitments / Total Commitments         
@endif