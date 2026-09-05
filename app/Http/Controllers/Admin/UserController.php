<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::with('role')->latest()->get(),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        if ($user->role_id === 1 && (int) $validated['role_id'] !== 1) {
            $remainingAdmins = User::where('role_id', 1)->where('id', '!=', $user->id)->count();

            if ($remainingAdmins === 0) {
                return back()->withErrors(['role_id' => 'You cannot remove the only admin account.'])->withInput();
            }
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('status', 'user-updated');
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        if ($user->is_active && $user->isAdmin() && User::where('role_id', 1)->where('is_active', true)->count() <= 1) {
            return back()->with('error', 'You cannot deactivate the only active admin.');
        }

        $user->update(['is_active' => ! $user->is_active]);

        return back()->with('status', $user->is_active ? 'user-activated' : 'user-deactivated');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->isAdmin() && User::where('role_id', 1)->count() <= 1) {
            return back()->with('error', 'You cannot delete the only admin account.');
        }

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'user-deleted');
    }
}
