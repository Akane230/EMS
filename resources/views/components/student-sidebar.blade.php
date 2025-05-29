<aside class="sidebar"
    x-data="{}"
    x-init="$nextTick(() => {})"
    :class="{ 'sidebar-hidden': !$store.layout.sidebarOpen }">

    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <span class="logo-text">EMS Student Portal</span>
    </div>

    <nav class="nav-menu">
        <div class="nav-section">
            <div class="nav-section-title">Main</div>
            <a href="{{ route('studentSide.dashboard') }}" class="nav-link @active(request()->is('studentSide/dashboard'))">
                <span class="nav-icon"><i class="fas fa-th-large"></i></span>
                Dashboard
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Academic</div>
            <a href="{{ route('studentSide.enrollment.index') }}" class="nav-link @active(request()->routeIs('studentSide.enrollment.*'))">
                <span class="nav-icon"><i class="fas fa-clipboard-list"></i></span>
                My Enrollments
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Documents</div>
            <a href="{{ route('studentSide.enrollment.download.cor') }}" class="nav-link">
                <span class="nav-icon"><i class="fas fa-file-alt"></i></span>
                Download COR
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Student Profile</div>
            <a href="{{ route('studentSide.profile.show') }}" class="nav-link @active(request()->routeIs('studentSide.profile.show*'))">
                <span class="nav-icon"><i class="fa-solid fa-circle-user"></i></span>
                My Profile
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
                <div class="user-name">{{ auth()->user()->student->first_name }}</div>
                <div class="user-role">{{ auth()->user()->student->student_id ?? 'Student' }}</div>
            </div>
        </div>
    </div>
</aside>