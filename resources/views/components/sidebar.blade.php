<aside class="sidebar"
    x-data="{}"
    x-init="$nextTick(() => {})"
    :class="{
          'sidebar-collapsed': !$store.layout.sidebarOpen, 
          'sidebar-open': $store.layout.sidebarOpen && window.innerWidth < 992
      }">

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
            <a href="#" class="nav-link @active(request()->is('calendar'))">
                <span class="nav-icon"><i class="fas fa-calendar-alt"></i></span>
                Calendar
            </a>
            <a href="#" class="nav-link @active(request()->is('analytics'))">
                <span class="nav-icon"><i class="fas fa-chart-bar"></i></span>
                Analytics
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
            <a href="#" class="nav-link @active(request()->is('enrollment'))">
                <span class="nav-icon"><i class="fas fa-clipboard-list"></i></span>
                Enrollment
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
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Settings</div>
            <a href="#" class="nav-link @active(request()->is('settings/system'))">
                <span class="nav-icon"><i class="fas fa-cog"></i></span>
                System Settings
            </a>
            <a href="#" class="nav-link @active(request()->is('settings/users'))">
                <span class="nav-icon"><i class="fas fa-users-cog"></i></span>
                User Management
            </a>
            <a href="#" class="nav-link @active(request()->is('settings/permissions'))">
                <span class="nav-icon"><i class="fas fa-shield-alt"></i></span>
                Permissions
            </a>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="avatar">
                <i class="fas fa-user"></i>
            </div>
            <div>
                <div class="user-name">{{ $userName ?? 'Admin User' }}</div>
                <div class="user-role">{{ $userRole ?? 'Administrator' }}</div>
            </div>
        </div>
    </div>
</aside>