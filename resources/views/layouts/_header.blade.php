<header class="mb-3 d-print-none">
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light" role="navigation">
        <div class="container">
            <sidebar-nav v-cloak>
                <h1 class="navbar-brand brand-font text-center"> Menu</h1>
                <ul class="nav nav-pills flex-column flex-nowrap">
                    @auth
                    @if ($activeGroup = auth()->user()->activeGroup)
                        <b-dropdown-header><h5>{{ auth()->user()->name }}</h5></b-dropdown-header>
                        <b-nav-item class="pl-2 pt-0 pb-0 "
                                    href="{{ route('groups.member-dashboard', $activeGroup->slug) }}">My Home
                        </b-nav-item>
                        <b-nav-item class="pl-2 "
                                    href="{{ route('groups.profiles.plan.edit', ['group'=>$activeGroup->slug, 'member'=>auth()->user()->activeGroupMember->id] ) }}">
                            My Plan
                        </b-nav-item>
                        <b-nav-item class="pl-2 " href="{{ route('groups.discussions.index', $activeGroup->slug) }}">
                            Discussions
                        </b-nav-item>
                        <b-nav-item class="pl-2 " href="{{ route('groups.analytics.index', $activeGroup->slug) }}">My
                            Analytics
                        </b-nav-item>
                        <b-nav-item class="pl-2 " href="{{ route('groups.meetings.index', $activeGroup->slug) }}">Group
                            Meetings
                        </b-nav-item>
                        <b-nav-item class="pl-2 " href="{{ route('groups.profiles.index', $activeGroup->slug) }}">Member
                            Profiles
                        </b-nav-item>
                        <b-nav-item class="pl-2 " href="{{ route('groups.give-feedback', $activeGroup->slug) }}">Give
                            Feedback
                        </b-nav-item>
                        <b-nav-item class="pl-2 " href="{{ route('manage-group.show', $activeGroup->slug) }}">My Group
                        </b-nav-item>

                        @can('facilitate', $activeGroup)
                            <b-dropdown-divider></b-dropdown-divider>
                            <b-dropdown-header><h5>{{ $activeGroup->name }}</h5></b-dropdown-header>

                            <b-nav-item class="pl-2" href="{{ route('insights.analytics') }}">Group Insights
                            </b-nav-item>
                            <b-nav-item class="pl-2" href="{{ route('manage-members.index') }}">Manage Members
                            </b-nav-item>
                            <b-nav-item class="pl-2 " href="{{ route('groups.config.about') }}">Manage group
                            </b-nav-item>
                            <b-nav-item class="pl-2" href="{{ route('manage-group.edit', $activeGroup->slug) }}">Edit
                                Group Profile
                            </b-nav-item>
                        @endcan

                    @else
                        <b-dropdown-header>(no active group set)</b-dropdown-header>
                    @endif

                    <b-dropdown-divider></b-dropdown-divider>
                    <b-dropdown-header><h5>My Account</h5></b-dropdown-header>
                    @can('manage', $activeGroup)
                        <b-nav-item class="pl-2" href="{{ route('accounts.index') }}">Account Management</b-nav-item>
                    @endcan
                    <b-nav-item class="pl-2 " href="{{ route('active-group.index') }}">Switch current group</b-nav-item>
                    <b-nav-item class="pl-2" href="{{ url('password/reset-email') }}">Change Password</b-nav-item>
                    <li class="nav-item pl-2">
                        <form action="{{ route('logout') }}"
                              method="POST">
                            {{ csrf_field() }}
                            <input type="submit" value="Logout" class="no-style-button nav-link">
                        </form>
                    </li>
                    @endauth

                    @guest
                    <b-nav-item class="pl-2 " href="{{ route('login') }}">Login</b-nav-item>
                    <b-nav-item class="pl-2 " href="{{ route('register') }}">Sign up</b-nav-item>
                    @endguest
                </ul>
            </sidebar-nav>
            &nbsp Menu

            <a href="{{ url('/') }}" class="ml-auto">
                <h1 class="navbar-brand brand-font mb-0">
                    <img class="logo-keepical" src="{{asset('images/keepical_wordlogo.png')}}">
                </h1>
            </a>
        </div>
    </nav>
</header>