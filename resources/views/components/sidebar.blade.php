<aside class="sidebar"
    x-data="{}"
    x-init="$nextTick(() => {})"
    :class="{ 'sidebar-hidden': !$store.layout.sidebarOpen }">

    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <span class="logo-text">EMS Online Platform</span>
    </div>

    <nav class="nav-menu">
        <div class="nav-section">
            <div class="nav-section-title">Main</div>
            <a href="{{ route('dashboard') }}" class="nav-link @active(request()->is('dashboard'))">
                <span class="nav-icon"><i class="fas fa-th-large"></i></span>
                Dashboard
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Management</div>
            <a href="{{ route('students.index') }}" class="nav-link @active(request()->routeIs('students.*'))">
                <span class="nav-icon"><i class="fas fa-user-graduate"></i></span>
                Students
            </a>
            <a href="{{ route('courses.index') }}" class="nav-link @active(request()->routeIs('courses.*'))">
                <span class="nav-icon"><i class="fas fa-book"></i></span>
                Courses
            </a>
            <a href="{{ route('instructors.index') }}" class="nav-link @active(request()->routeIs('instructors.*'))">
                <span class="nav-icon"><i class="fas fa-chalkboard-teacher"></i></span>
                Instructors
            </a>
            <a href="{{ route('departments.index') }}" class="nav-link @active(request()->routeIs('departments.*'))">
                <span class="nav-icon"><i class="fas fa-building"></i></span>
                Departments
            </a>
            <a href="{{ route('programs.index') }}" class="nav-link @active(request()->routeIs('programs.*'))">
                <span class="nav-icon"> <img class="nav-img" src="{{ asset('images/program.png') }}" alt=""></span>
                Programs
            </a>
            <a href="{{ route('sections.index') }}" class="nav-link @active(request()->routeIs('sections.*'))">
                <span class="nav-icon"><i class="fa-solid fa-section"></i></span>
                Sections
            </a>
            <a href="{{ route('rooms.index') }}" class="nav-link @active(request()->routeIs('rooms.*'))">
                <span class="nav-icon"><i class="fa-solid fa-building-user"></i></span>
                Rooms
            </a>
            <a href="{{ route('terms.index') }}" class="nav-link @active(request()->routeIs('terms.*'))">
                <span class="nav-icon"><i class="fa-solid fa-calendar"></i></span>
                Terms
            </a>
            <a href="{{ route('positions.index') }}" class="nav-link @active(request()->routeIs('positions.*'))">
                <span class="nav-icon"> <img class="nav-img" src="{{ asset('images/position.png') }}" alt=""></span>
                Positions
            </a>

        </div>

        <div class="nav-section">
            <div class="nav-section-title">Transactions</div>
            <a href="{{ route('enrollments.index') }}" class="nav-link @active(request()->is('enrollments'))">
                <span class="nav-icon"><i class="fas fa-clipboard-list"></i></span>
                Enrollment
            </a>
            <a href="{{ route('schedules.index') }}" class="nav-link @active(request()->routeIs('schedules.*'))">
                <span class="nav-icon"><i class="fa-solid fa-clock"></i></span>
                Schedules
            </a>
            <a href="{{ route('instructor-positions.index') }}" class="nav-link @active(request()->routeIs('instructor-positions.*'))">
                <span class="nav-icon"><img class="nav-img" src="{{ asset('images/position.png') }}" alt=""></i></span>
                Instructor Positions
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Settings</div>
            <a href="{{ route('users.index') }}" class="nav-link @active(request()->is('users.*'))">
                <span class="nav-icon"><i class="fas fa-users-cog"></i></span>
                User Management
            </a>
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="nav-icon"><i class="fas fa-sign-out-alt"></i></span>
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="avatar">
                @if(auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Profile" class="avatar-image">
                @else
                <i class="fas fa-user"></i>
                @endif
            </div>
            <div>
                <div class="user-name">{{ $userName ?? 'Admin User' }}</div>
                <div class="user-role">{{ $userRole ?? 'Administrator' }}</div>
            </div>
        </div>
    </div>
</aside>