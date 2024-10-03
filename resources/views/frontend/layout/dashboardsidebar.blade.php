<div class="col-lg-4" style="width: 20.333333%;">
    <div class="cta-sidebar sidebar" style="background-color:#5e5e5e;">
        <div class="cta-menu-bar">
		<a href="{{url('/')}}/dashboard" class="brand-link" style="text-decoration: none; display: block; background-color: #2b92ad; padding: 6px; border-radius: 22px; text-align: center; color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease;">
    <span style="font-size: 20px; font-weight: 600; display: block;">Welcome</span>
    <span style="font-size: 24px; font-weight: 700;">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</span>
</a>

<style>
    .brand-link:hover {
        background-color: #1b171e; /* Darker blue on hover */
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Increased shadow on hover */
        color: white; /* Keep text color white on hover */
    }
</style>

            <ul class="cta-menu" style="list-style-type: none; padding: 0;">
                <li style="margin-bottom: 15px;">
                    <a class="{{ Route::currentRouteName() === 'dashboard.index' ? 'nav-active' : '' }}" href="{{route('dashboard.index')}}" style="display: block; padding: 10px; cursor: pointer; text-decoration: none; color: inherit; border-radius: 20px;">
                        Profile
                    </a>
                </li>
                <li style="margin-bottom: 15px;">
                    <a class="{{ Route::currentRouteName() === 'track' || Route::currentRouteName() === 'editalert' ? 'nav-active' : '' }}" href="{{route('track')}}" style="display: block; padding: 10px; cursor: pointer; text-decoration: none; color: inherit; border-radius: 20px;">
                        Track
                    </a>
                </li>
                <li style="margin-bottom: 15px;">
                    <a class="{{ request()->is('plans') ? 'nav-active' : '' }}" href="{{url('/')}}#plans" style="display: block; padding: 10px; cursor: pointer; text-decoration: none; color: inherit; border-radius: 20px;">
                        Edit Plan
                    </a>
                </li>
                <li style="display:none; margin-bottom: 15px;">
                    <a class="{{ Route::currentRouteName() === 'myalerts' || Route::currentRouteName() === 'editalert' ? 'nav-active' : '' }}" href="{{route('myalerts')}}" style="display: block; padding: 10px; cursor: pointer; text-decoration: none; color: inherit; border-radius: 20px;">
                        My Alerts
                    </a>
                </li>
                <li>
                    <a class="{{ Route::currentRouteName() === 'logout' ? 'nav-active' : '' }}" href="{{route('logout')}}" style="display: block; padding: 10px; cursor: pointer; text-decoration: none; color: inherit; border-radius: 20px;">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
    .cta-menu a {
        transition: background-color 0.3s, color 0.3s;
    }

    .cta-menu a:hover {
        background-color: #f0f0f0; /* Hover background */
        color: #007bff; /* Hover text color */
    }

    .nav-active {
        background-color: #5cb6ce; /* Active background */
        color: white !important; /* Active text color */
    }

    .cta-menu a.nav-active:hover {
        background-color: #0056b3; /* Darker active background on hover */
    }
</style>
