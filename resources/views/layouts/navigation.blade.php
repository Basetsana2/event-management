<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="{{ route('home') }}">EventManager</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('events.index') }}">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('events.calendar') }}">Calendar</a>
                </li>

                @auth
                    @if(auth()->user()->role === 'organizer')
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('events.mine') }}">My Events</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('registrations.pending') }}">Pending Approvals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('events.create') }}">Create Event</a>
                        </li>
                    @elseif(auth()->user()->role === 'attendee')
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('registrations.mine') }}">My Registrations</a>
                        </li>
                    @elseif(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('register') }}">Register</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
