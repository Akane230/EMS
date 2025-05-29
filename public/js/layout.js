// public/js/layout.js
document.addEventListener('DOMContentLoaded', function() {
    // Wait for Alpine to be available
    document.addEventListener('alpine:init', () => {
        console.log('Alpine initializing...');
        
        // Create a global store for layout state
        Alpine.store('layout', {
            darkMode: localStorage.getItem('darkMode') === 'true' || false,
            sidebarOpen: window.innerWidth >= 992,
            
            init() {
                console.log('Layout store initialized', {
                    darkMode: this.darkMode,
                    sidebarOpen: this.sidebarOpen
                });
            },
            
            toggleSidebar() {
                console.log("Toggling sidebar from:", this.sidebarOpen, "to:", !this.sidebarOpen);
                this.sidebarOpen = !this.sidebarOpen;
            },
            
            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                localStorage.setItem('darkMode', this.darkMode.toString());
                console.log('Dark mode toggled to:', this.darkMode);
            }
        });
        
        // Initialize the store
        Alpine.store('layout').init();
        
        console.log('Alpine store created');
    });
    
    // Initialize window resize listener after Alpine is ready
    window.addEventListener('alpine:initialized', () => {
        console.log('Alpine fully initialized');
        
        window.addEventListener('resize', () => {
            const store = Alpine.store('layout');
            if (store) {
                if (window.innerWidth >= 992) {
                    store.sidebarOpen = true;
                } else {
                    // On mobile, keep current state or close
                    // store.sidebarOpen = false; // Uncomment if you want to auto-close on mobile
                }
            }
        });
    });
});