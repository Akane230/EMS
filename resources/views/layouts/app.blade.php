<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'EMS Dashboard' }}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.2/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
    <script src="{{ asset('js/layout.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    {{ $styles ?? '' }}
</head>

<body x-data 
      :class="{ 'dark': $store.layout.darkMode }">

    <div class="layout">
        <!-- Sidebar Component -->
        <x-sidebar :user-name="Auth::user()->name ?? 'Admin User'" :user-role="Auth::user()->role ?? 'Administrator'" />

        <!-- Main Content -->
        <div class="main-content" :class="{ 'main-content-expanded': !$store.layout.sidebarOpen }">
            <x-header />

            <main class="dashboard fade-in">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{ $scripts ?? '' }}
</body>

</html>