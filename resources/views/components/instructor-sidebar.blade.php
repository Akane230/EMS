<aside class="sidebar"
    x-data="{}"
    x-init="$nextTick(() => {})"
    :class="{ 'sidebar-hidden': !$store.layout.sidebarOpen }">

    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <span class="logo-text">EMS Instructor Portal</span>
    </div>

    <nav class="nav-menu">
        <div class="nav-section">
            <div class="nav-section-title">Main</div>
            <a href="{{ route('instructor.dashboard') }}" class="nav-link @active(request()->is('instructor/dashboard'))">
                <span class="nav-icon"><i class="fas fa-th-large"></i></span>
                Dashboard
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Students</div>
            <a href="{{ route('instructor.students.index') }}" class="nav-link @active(request()->routeIs('instructor.students.index'))">
                <span class="nav-icon"><i class="fas fa-users"></i></span>
                All Students
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Reports</div>
            <a href="{{ route('instructor.students.pdf') }}" class="nav-link @active(request()->routeIs('instructor.students.pdf'))">
                <span class="nav-icon"><i class="fas fa-file-pdf"></i></span>
                Export All Students
            </a>
            <a href="{{ route('instructor.schedule.pdf') }}" class="nav-link @active(request()->routeIs('instructor.schedule.pdf'))">
                <span class="nav-icon"><i class="fas fa-calendar-alt"></i></span>
                Export Schedule
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Account</div>
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
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Instructor</div>
            </div>
        </div>
    </div>
</aside>