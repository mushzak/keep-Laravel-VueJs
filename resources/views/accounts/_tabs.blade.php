<h2>Account management</h2>

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ $active == 'account' ? 'active' : '' }}" href="{{ route('accounts.index') }}">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active == 'subscriptions' ? 'active' : '' }}" href="{{ route('accounts.subscriptions') }}">Subscription Plan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active == 'groups' ? 'active' : '' }}" href="{{ route('accounts.groups') }}">Group Management</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active == 'branding' ? 'active' : '' }}" href="{{ route('accounts.branding') }}">Branding</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active == 'contact' ? 'active' : '' }}" href="{{ route('accounts.contact') }}">Contact Information</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active == 'security' ? 'active' : '' }}" href="{{ route('accounts.security') }}">Security Settings</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active == 'integrations' ? 'active' : '' }}" href="{{ route('accounts.integrations') }}">Application Integrations</a>
    </li>
    {{--<li class="nav-item">--}}
        {{--<a class="nav-link {{ $active == 'notifications' ? 'active' : '' }}" href="{{ route('accounts.notifications') }}">Notifications</a>--}}
    {{--</li>--}}
</ul>