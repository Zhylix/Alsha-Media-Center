<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminManagerController extends Controller
{
    /**
     * Display list of admins - only accessible by superadmin
     */
    public function index()
    {
        $admins = Admin::orderBy('role', 'desc')->orderBy('name')->get();
        
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show form to create new admin - only accessible by superadmin
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store new admin - only accessible by superadmin
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins,username',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
            'whatsapp' => 'nullable|string|max:20',
            'role' => 'required|in:superadmin,admin',
            'is_active' => 'nullable|boolean',
        ]);

        Admin::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'whatsapp' => $request->whatsapp,
            'role' => $request->role,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin ' . $request->name . ' berhasil dibuat!');
    }

    /**
     * Show form to edit admin - only accessible by superadmin
     */
    public function edit(Admin $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Update admin - only accessible by superadmin
     */
    public function update(Request $request, Admin $admin)
    {
        // Prevent superadmin from deactivating themselves
        $adminId = session('admin_id');
        
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('admins', 'username')->ignore($admin->id)],
            'email' => ['required', 'email', Rule::unique('admins', 'email')->ignore($admin->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'whatsapp' => 'nullable|string|max:20',
            'role' => 'required|in:superadmin,admin',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'role' => $request->role,
            'is_active' => $request->is_active ?? ($admin->is_active ?? true),
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Prevent from deactivating own account
        if ($admin->id == $adminId && $request->has('is_active') && !$request->is_active) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $admin->update($data);

        return redirect()->route('admin.admins.index')->with('success', 'Admin ' . $admin->name . ' berhasil diperbarui!');
    }

    /**
     * Delete admin - only accessible by superadmin
     */
    public function destroy(Admin $admin)
    {
        $adminId = session('admin_id');
        
        // Prevent superadmin from deleting themselves
        if ($admin->id == $adminId) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $adminName = $admin->name;
        $admin->delete();

        return redirect()->route('admin.admins.index')->with('success', 'Admin ' . $adminName . ' berhasil dihapus!');
    }

    /**
     * Toggle admin active status - only accessible by superadmin
     */
    public function toggleActive(Admin $admin)
    {
        $adminId = session('admin_id');
        
        // Prevent superadmin from toggling themselves
        if ($admin->id == $adminId) {
            return back()->with('error', 'Anda tidak dapat mengubah status akun Anda sendiri.');
        }

        $admin->update(['is_active' => !$admin->is_active]);
        
        $status = $admin->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return back()->with('success', 'Admin ' . $admin->name . ' berhasil ' . $status . '!');
    }
}
