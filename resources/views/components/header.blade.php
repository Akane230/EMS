<header class="top-bar">
    <button class="menu-toggle"
        @click="$store.layout.toggleSidebar()"
        type="button">
        <i class="fas fa-bars"></i>
    </button>

    <div class="user-actions">
        <button class="action-btn">
            <i class="fas fa-bell"></i>
            <span class="notification-badge">3</span>
        </button>
        <button class="action-btn">
            <i class="fas fa-envelope"></i>
            <span class="notification-badge">5</span>
        </button>
        <button class="theme-toggle" @click="$store.layout.toggleDarkMode()">
            <i class="fas" :class="$store.layout.darkMode ? 'fa-sun' : 'fa-moon'"></i>
        </button>
    </div>
</header>