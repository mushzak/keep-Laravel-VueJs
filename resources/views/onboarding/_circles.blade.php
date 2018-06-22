<div class="d-flex justify-content-center">
    @foreach (range(1, $total) as $i)
        @if ($current == $i)
            <i class="fa fa-circle-o mr-1"></i>
        @else
            <i class="fa fa-circle mr-1"></i>
        @endif
    @endforeach
</div>