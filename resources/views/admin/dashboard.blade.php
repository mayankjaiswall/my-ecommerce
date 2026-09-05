@extends('layouts.admin')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, ' . explode(' ', auth()->user()->name)[0] . '. Here is what is happening today.')

@section('content')

    <div class="admin-stats-grid">
        <div class="admin-stat-card">
            <div class="admin-stat-card__top">
                <span class="admin-stat-card__icon" style="background: #1f1f1f;">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.333 17.5v-1.667a3.333 3.333 0 0 0-3.333-3.333H4.167a3.333 3.333 0 0 0-3.334 3.333V17.5M9.167 9.167a3.333 3.333 0 1 0 0-6.667 3.333 3.333 0 0 0 0 6.667ZM17.5 17.5v-1.667a3.333 3.333 0 0 0-2.5-3.226M11.667 2.559a3.333 3.333 0 0 1 0 6.455" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </div>
            <div class="admin-stat-card__value">{{ number_format($totalUsers) }}</div>
            <div class="admin-stat-card__label">Total Users</div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-card__top">
                <span class="admin-stat-card__icon" style="background: #c32929;">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 1.667 3.75 4.167v4.958c0 3.158 2.667 6.117 6.25 7.208 3.583-1.091 6.25-4.05 6.25-7.208V4.167L10 1.667Z" stroke="#fff" stroke-width="1.5" stroke-linejoin="round"/>
                        <path d="m7.417 9.833 1.75 1.75 3.583-4" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </div>
            <div class="admin-stat-card__value">{{ number_format($totalAdmins) }}</div>
            <div class="admin-stat-card__label">Admin Accounts</div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-card__top">
                <span class="admin-stat-card__icon" style="background: #b9a16b;">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.333 17.5H2.5v-1.667A3.333 3.333 0 0 1 5.833 12.5h4.167a3.333 3.333 0 0 1 3.333 3.333V17.5ZM7.917 9.167a3.333 3.333 0 1 0 0-6.667 3.333 3.333 0 0 0 0 6.667ZM15 12.5c1.933 0 3.5 1.567 3.5 3.5v1.5h-2" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </div>
            <div class="admin-stat-card__value">{{ number_format($totalCustomers) }}</div>
            <div class="admin-stat-card__label">Customer Accounts</div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-card__top">
                <span class="admin-stat-card__icon" style="background: #767676;">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.667 1.667V5M13.333 1.667V5M2.917 8.333h14.166M4.167 3.333h11.666c.92 0 1.667.747 1.667 1.667v10.833a1.667 1.667 0 0 1-1.667 1.667H4.167A1.667 1.667 0 0 1 2.5 15.833V5c0-.92.746-1.667 1.667-1.667Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </div>
            <div class="admin-stat-card__value">{{ number_format($newThisMonth) }}</div>
            <div class="admin-stat-card__label">New This Month</div>
        </div>
    </div>

    <div class="admin-panels-grid">
        <div class="admin-panel">
            <div class="admin-panel__header">
                <div>
                    <h3 class="admin-panel__title">User Growth</h3>
                    <p class="admin-panel__subtitle">New registrations over the last 6 months</p>
                </div>
            </div>
            <div class="admin-chart-wrap">
                <canvas id="growthChart"></canvas>
            </div>
        </div>

        <div class="admin-panel">
            <div class="admin-panel__header">
                <div>
                    <h3 class="admin-panel__title">Role Distribution</h3>
                    <p class="admin-panel__subtitle">Accounts by assigned role</p>
                </div>
            </div>
            <div class="admin-chart-wrap admin-chart-wrap--donut">
                <canvas id="roleChart"></canvas>
            </div>
            <div class="admin-legend">
                @foreach ($roleBreakdown as $index => $role)
                    <div class="admin-legend__item">
                        <span class="admin-legend__dot" style="background: {{ ['#1f1f1f', '#c32929', '#b9a16b', '#767676'][$index % 4] }};"></span>
                        <span>{{ \Illuminate\Support\Str::title(str_replace('_', ' ', $role->name)) }}</span>
                        <span class="admin-legend__value">{{ $role->users_count }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="admin-table-wrap">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentUsers as $recentUser)
                    <tr>
                        <td>
                            <div class="admin-table-user">
                                <span class="admin-avatar">
                                    {{ strtoupper(substr($recentUser->name, 0, 1)) }}
                                </span>
                                <div>
                                    <div class="admin-table-user__name">{{ $recentUser->name }}</div>
                                    <div class="admin-table-user__email">{{ $recentUser->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if ($recentUser->role && $recentUser->role->name === 'admin')
                                <span class="admin-badge admin-badge--admin">Admin</span>
                            @else
                                <span class="admin-badge admin-badge--user">Customer</span>
                            @endif
                        </td>
                        <td>{{ $recentUser->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No users yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        var growthCtx = document.getElementById('growthChart');
        new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: @json($trendLabels),
                datasets: [{
                    label: 'New Users',
                    data: @json($trendData),
                    borderColor: '#c32929',
                    backgroundColor: 'rgba(195, 41, 41, 0.08)',
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#c32929',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#ece7df' } },
                    x: { grid: { display: false } }
                }
            }
        });

        var roleCtx = document.getElementById('roleChart');
        new Chart(roleCtx, {
            type: 'doughnut',
            data: {
                labels: @json($roleBreakdown->pluck('name')),
                datasets: [{
                    data: @json($roleBreakdown->pluck('users_count')),
                    backgroundColor: ['#1f1f1f', '#c32929', '#b9a16b', '#767676'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: { legend: { display: false } }
            }
        });
    </script>
@endpush
