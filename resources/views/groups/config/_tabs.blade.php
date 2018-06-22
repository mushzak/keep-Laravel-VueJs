<h2>Manage group</h2>

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ $active == 'about' ? 'active' : '' }}" href="{{ route('groups.config.about') }}">What We Are About</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active == 'agreements' ? 'active' : '' }}" href="{{ route('groups.config.agreements') }}">Agreements</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active == 'feedback' ? 'active' : '' }}" href="{{ route('groups.config.feedback') }}">Feedback</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active == 'check-ins' ? 'active' : '' }}" href="{{ route('groups.config.check-ins') }}">Check-Ins</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active == 'planning' ? 'active' : '' }}" href="{{ route('groups.config.planning') }}">Member Plan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active == 'profiles' ? 'active' : '' }}" href="{{ route('groups.config.profiles') }}">Member Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active == 'engagement' ? 'active' : '' }}" href="{{ route('groups.config.engagement') }}">Member Engagement</a>
    </li>
</ul>