<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalUsers = User::count();
        $totalAdmins = User::where('role_id', 1)->count();
        $totalCustomers = $totalUsers - $totalAdmins;
        $newThisMonth = User::where('created_at', '>=', now()->startOfMonth())->count();

        $recentUsers = User::with('role')->latest()->take(6)->get();

        $roleBreakdown = Role::withCount('users')->get();

        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i));

        $trendLabels = $months->map(fn ($month) => $month->format('M'))->values();

        $trendData = $months->map(function ($month) {
            return User::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        })->values();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalAdmins' => $totalAdmins,
            'totalCustomers' => $totalCustomers,
            'newThisMonth' => $newThisMonth,
            'recentUsers' => $recentUsers,
            'roleBreakdown' => $roleBreakdown,
            'trendLabels' => $trendLabels,
            'trendData' => $trendData,
        ]);
    }
}
