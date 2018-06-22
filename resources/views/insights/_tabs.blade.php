<h2>Group Insights</h2>

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ $active == 'analytics' ? 'active' : '' }}" href="{{ route('insights.analytics') }}">Analytics</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active == 'feedback' ? 'active' : '' }}" href="{{ route('insights.feedback') }}">Feedback</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active == 'history' ? 'active' : '' }}" href="{{ route('insights.history') }}">History</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active == 'praise' ? 'active' : '' }}" href="{{ route('insights.praise') }}">Praise</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active == 'exceptions' ? 'active' : '' }}" href="{{ route('insights.exceptions') }}">Exceptions</a>
    </li>
</ul>