// public/js/layout.js
document.addEventListener('alpine:init', () => {
    // Create a global store for layout state
    Alpine.store('layout', {
        darkMode: localStorage.getItem('darkMode') === 'true',
        sidebarOpen: window.innerWidth >= 992,
        
        toggleSidebar() {
            console.log("Toggling sidebar:", this.sidebarOpen); // Check if this logs on click
            this.sidebarOpen = !this.sidebarOpen;
        },
        
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('darkMode', this.darkMode);
        }
    });
    
    // Initialize window resize listener
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 992) {
            Alpine.store('layout').sidebarOpen = true;
        }
    });
});
