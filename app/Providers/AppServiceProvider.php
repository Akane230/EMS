<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Create a custom Blade directive for active link detection
        Blade::directive('active', function ($expression) {
            return "<?php echo $expression ? 'active' : ''; ?>";
        });
        
        // Redirect based on role after login
        Gate::after(function ($user, $ability) {
            if ($user->role === 'Student') {
                return redirect()->intended(route('studentSide.dashboard'));
            }   
            if ($user->role === 'Admin') {
                return redirect()->intended(route('admin.dashboard'));
            }
        });
    }
}