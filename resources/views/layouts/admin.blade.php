<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>@yield('page-title', 'Dashboard') - Admin - {{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    @stack('styles')
    <script>
        (function () {
            try {
                if (localStorage.getItem('admin-sidebar-collapsed') === '1') {
                    document.documentElement.classList.add('admin-sidebar-collapsed');
                }
            } catch (e) {}
        })();

        (function () {
            try {
                var stored = localStorage.getItem('admin-theme');
                var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (stored === 'dark' || (!stored && prefersDark)) {
                    document.documentElement.classList.add('admin-theme-dark');
                }
            } catch (e) {}
        })();
    </script>
</head>
<body class="admin-body">
    @php $user = auth()->user(); @endphp

    <div class="admin-shell">
        <div class="admin-overlay" id="adminOverlay"></div>

        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-sidebar__brand">
                <a href="{{ route('home') }}" class="admin-sidebar__brand-logo">
                    <x-logo class="admin-sidebar__brand-logo-img d-block" />
                </a>
                <span class="admin-sidebar__brand-tag">Admin Panel</span>
                <button type="button" class="admin-sidebar-collapse-toggle" id="adminSidebarCollapseToggle" aria-label="Collapse sidebar" aria-expanded="true" title="Collapse sidebar">
                    <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.5 4.167 7.5 10l5 5.833" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>

            <nav class="admin-nav">
                <p class="admin-nav__label">Overview</p>
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" title="Dashboard">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 8.333 10 2.5l7.5 5.833V16.5a1 1 0 0 1-1 1h-4.167v-5.417H7.667V17.5H3.5a1 1 0 0 1-1-1V8.333Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                    </svg>
                    <span class="admin-nav-link__label">Dashboard</span>
                </a>

                <p class="admin-nav__label">Management</p>
                <a href="{{ route('admin.users.index') }}" class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}" title="Users">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.333 17.5v-1.667a3.333 3.333 0 0 0-3.333-3.333H4.167a3.333 3.333 0 0 0-3.334 3.333V17.5M17.5 17.5v-1.667a3.333 3.333 0 0 0-2.5-3.226M11.667 2.559a3.333 3.333 0 0 1 0 6.455M9.167 9.167a3.333 3.333 0 1 0 0-6.667 3.333 3.333 0 0 0 0 6.667Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="admin-nav-link__label">Users</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="admin-nav-link {{ request()->routeIs('admin.categories.*') ? 'is-active' : '' }}" title="Categories">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.5 10.833 10.833 17.5a1.667 1.667 0 0 1-2.357 0L2.5 11.524V2.5h9.024l5.976 5.976a1.667 1.667 0 0 1 0 2.357Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                        <path d="M6.667 6.667h.008" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span class="admin-nav-link__label">Categories</span>
                </a>
                <span class="admin-nav-link is-disabled" title="Products">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 6.25 10 2.5l7.5 3.75-7.5 3.75-7.5-3.75Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                        <path d="M2.5 6.25V13.75L10 17.5l7.5-3.75V6.25M10 10v7.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                    </svg>
                    <span class="admin-nav-link__label">Products</span>
                    <span class="admin-soon">Soon</span>
                </span>
                <span class="admin-nav-link is-disabled" title="Orders">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 5h15M5 5V3.333A1.667 1.667 0 0 1 6.667 1.667h6.666A1.667 1.667 0 0 1 15 3.333V5m2.5 0-.833 11.25A1.667 1.667 0 0 1 15 17.917H5a1.667 1.667 0 0 1-1.667-1.667L2.5 5h15Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                    </svg>
                    <span class="admin-nav-link__label">Orders</span>
                    <span class="admin-soon">Soon</span>
                </span>
            </nav>

            <div class="admin-sidebar__footer">
                <a href="{{ route('admin.profile.edit') }}" class="admin-sidebar__user admin-sidebar__user--link" title="{{ $user->name }}">
                    <span class="admin-avatar">
                        @if ($user->avatar_url)
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                        @else
                            {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                        @endif
                    </span>
                    <div class="admin-sidebar__user-info">
                        <div class="admin-sidebar__user-name">{{ $user->name }}</div>
                        <div class="admin-sidebar__user-role">{{ $user->email }}</div>
                    </div>
                </a>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="admin-logout-btn" title="Sign Out">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.5 17.5h-3.333a1.667 1.667 0 0 1-1.667-1.667V4.167A1.667 1.667 0 0 1 4.167 2.5H7.5M13.333 14.167 17.5 10l-4.167-4.167M17.5 10H7.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="admin-logout-btn__label">Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <div class="admin-topbar__left">
                    <button type="button" class="admin-sidebar-toggle" id="adminSidebarToggle" aria-label="Toggle sidebar">
                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.5 5h15M2.5 10h15M2.5 15h15" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </button>
                    <div>
                        <p class="admin-topbar__title">@yield('page-title', 'Dashboard')</p>
                        <p class="admin-topbar__subtitle">@yield('page-subtitle', 'Welcome back to your admin panel')</p>
                    </div>
                </div>

                <div class="admin-topbar__right">
                    <button type="button" class="admin-theme-toggle" id="adminThemeToggle" aria-label="Toggle dark theme" aria-pressed="false" title="Switch to dark theme">
                        <svg class="admin-theme-toggle__icon admin-theme-toggle__icon--moon" width="17" height="17" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.5 10.708A7.5 7.5 0 1 1 9.292 2.5a6.083 6.083 0 0 0 8.208 8.208Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                        </svg>
                        <svg class="admin-theme-toggle__icon admin-theme-toggle__icon--sun" width="17" height="17" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="10" cy="10" r="3.333" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M10 2.5v1.667M10 15.833V17.5M17.5 10h-1.667M4.167 10H2.5M15.303 4.697l-1.178 1.178M5.875 14.125l-1.178 1.178M15.303 15.303l-1.178-1.178M5.875 5.875 4.697 4.697" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </button>
                    <span class="admin-topbar__pill">
                        <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 1.667 3.75 4.167v4.958c0 3.158 2.667 6.117 6.25 7.208 3.583-1.091 6.25-4.05 6.25-7.208V4.167L10 1.667Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                        </svg>
                        <span>Administrator</span>
                    </span>
                    <a href="{{ route('admin.profile.edit') }}" class="admin-avatar admin-avatar--link" title="Edit profile" aria-label="Edit profile">
                        @if ($user->avatar_url)
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                        @else
                            {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                        @endif
                    </a>
                </div>
            </header>

            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        (function () {
            var sidebar = document.getElementById('adminSidebar');
            var overlay = document.getElementById('adminOverlay');
            var toggle = document.getElementById('adminSidebarToggle');

            function closeSidebar() {
                sidebar.classList.remove('is-open');
                overlay.classList.remove('is-open');
            }

            toggle.addEventListener('click', function () {
                sidebar.classList.toggle('is-open');
                overlay.classList.toggle('is-open');
            });

            overlay.addEventListener('click', closeSidebar);
        })();

        (function () {
            var collapseToggle = document.getElementById('adminSidebarCollapseToggle');
            var STORAGE_KEY = 'admin-sidebar-collapsed';

            function setCollapsed(collapsed) {
                document.documentElement.classList.toggle('admin-sidebar-collapsed', collapsed);
                collapseToggle.setAttribute('aria-expanded', String(!collapsed));
                collapseToggle.title = collapsed ? 'Expand sidebar' : 'Collapse sidebar';
                try { localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0'); } catch (e) {}
            }

            collapseToggle.addEventListener('click', function () {
                setCollapsed(!document.documentElement.classList.contains('admin-sidebar-collapsed'));
            });
        })();

        (function () {
            var themeToggle = document.getElementById('adminThemeToggle');
            var STORAGE_KEY = 'admin-theme';

            function setTheme(theme) {
                document.documentElement.classList.toggle('admin-theme-dark', theme === 'dark');
                themeToggle.setAttribute('aria-pressed', String(theme === 'dark'));
                themeToggle.title = theme === 'dark' ? 'Switch to light theme' : 'Switch to dark theme';
                try { localStorage.setItem(STORAGE_KEY, theme); } catch (e) {}
            }

            themeToggle.addEventListener('click', function () {
                var isDark = document.documentElement.classList.contains('admin-theme-dark');
                setTheme(isDark ? 'light' : 'dark');
            });

            setTheme(document.documentElement.classList.contains('admin-theme-dark') ? 'dark' : 'light');
        })();
    </script>

    @stack('scripts')
</body>
</html>
