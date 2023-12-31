{{-- <nav class="main-header navbar navbar-white navbar-light navbar-expand-lg bg-body-tertiary">
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" style="left: inherit; right: 0px;">
                <a href="{{ route('profile.show') }}" class="dropdown-item">
                    <i class="mr-2 fas fa-file"></i>
                    {{ __('My profile') }}
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" class="dropdown-item"
                       onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="mr-2 fas fa-sign-out-alt"></i>
                        {{ __('Log Out') }}
                    </a>
                </form>
            </div>
        </li>
    </ul>
</nav> --}}

<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>
    <div class="navbar-collapse collapse">
    @auth
        <ul class="navbar-nav navbar-align ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                    <div class="position-relative">
                        <i class="align-middle" data-feather="bell"></i>
                        @if(auth()->user()->unreadNotifications->isNotEmpty())
                            <span class="indicator">{{ auth()->user()->unreadNotifications->count() }}</span>
                        @endif
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" style="width: 400px;" aria-labelledby="alertsDropdown">
                @auth
                    @if(auth()->user()->notifications->isNotEmpty())
                        <div class="dropdown-menu-header">
                            {{ auth()->user()->unreadNotifications->count() }} Unread Notifications
                        </div>
                            <div class="notification-container" style="max-height: 500px; overflow-y: auto;">
                            <div class="list-group">
                                @foreach (auth()->user()->notifications as $notification)
                                    @if (isset($notification->data['request_id'], $notification->data['request_type']))
                                        @php
                                            $newsched = App\Models\NewSched::find($notification->data['request_id']);
                                            $formId = 'mark-as-read3-' . $notification->id;
                                        @endphp

                                        @if ($notification->data['request_type'] === "Reschedule Request")
                                        <a href="{{ route('faculty.managerequest') }}" class="list-group-item dropdown-item @if(!$notification->read_at) bg-primary @endif" onclick="event.preventDefault(); document.getElementById('{{ $formId }}').submit();">
                                            <div class="row g-0 align-items-center">
                                                <div class="col-2">
                                                    <i class="text-warning" data-feather="bell"></i>
                                                </div>
                                                <div class="col-10">
                                                    <div> New {{ $notification->data['request_type'] }}!</div>
                                                    <div class="float-left small mt-1">{{ $notification->data['stud_name'] }}: {{ $notification->data['subject'] }}</div>
                                                    <div class="float-right small mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                        </a>

                                        @elseif ($notification->data['request_type'] === "Special Exam Request")
                                        <a href="{{ route('faculty.studspecial') }}" class="list-group-item dropdown-item @if(!$notification->read_at) bg-primary @endif" onclick="event.preventDefault(); document.getElementById('{{ $formId }}').submit();">
                                            <div class="row g-0 align-items-center">
                                                    <div class="col-2">
                                                        <i class="text-warning" data-feather="bell"></i>
                                                    </div>
                                                    <div class="col-10">
                                                        <div> New {{ $notification->data['request_type'] }}!</div>
                                                        <div class="float-left small mt-1">{{ $notification->data['stud_name'] }}: {{ $notification->data['subject'] }}</div>
                                                        <div class="float-right small mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                                                    </div>
                                            </div>
                                        </a>

                                        @endif
                                        <form id="mark-as-read3-{{ $notification->id }}" action="{{ route('teachermarkAsRead', ['notificationId' => $notification->id]) }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>

                                        @if(!$notification->read_at)
                                            <!-- Add your unread styling or indicator here -->
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                            </div>
                @else
                    <span class="dropdown-item dropdown-header">No notifications yet.</span>
                @endif
                @else
                    <span class="dropdown-item dropdown-header">Please log in to view notifications.</span>
                @endauth

                </div>
            </li>
            
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>
                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <!-- <img src="{{asset('import/img/avatars/basan.png')}}" class="avatar img-fluid rounded me-1" alt="Charles Hall" />  -->
                    <span class="text-dark">{{ Auth::user()->name }}</span>
                </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- <a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i>Change Profile Image</a>
                        <div class="dropdown-divider"></div> -->
                        <a class="dropdown-item" href="{{ route('faculty.changepass2') }}"><i class="align-middle me-1" data-feather="user"></i> Change Password</a>
								<div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('faculty.aboutus') }}"><i class="align-middle me-1" data-feather="info"></i> About Us</a>
								<div class="dropdown-divider"></div>
                    {{-- <a class="dropdown-item" href="{{ route('logout') }}">Log out</a> --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="mr-2 fas fa-sign-out-alt"></i>
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
            </li>
        </ul>

    @elseguest
        <ul class="navbar-nav navbar-align">
            <a class="nav-icon dropdown-toggle" href="{{ route('login') }}" >
                Log in
            </a>
        </ul>
    @endauth
    </div>

    
        
    
</nav>