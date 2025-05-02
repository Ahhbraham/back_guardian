<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index()
    {
        try {
            $roles = Role::withTrashed()->get();
            return response()->json([
                'success' => true,
                'data' => $roles,
                'count' => $roles->count()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching roles: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new role.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            $role = Role::create([
                'name' => $request->name,
                'slug' => Str::slug($request->slug),
                'description' => $request->description
            ]);

            return response()->json([
                'success' => true,
                'data' => $role,
                'message' => 'Role created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified role.
     */
    public function show($id)
    {
        try {
            $role = Role::withTrashed()->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $role
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found or error fetching role: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles,slug,' . $id,
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            $role = Role::findOrFail($id);
            $role->update([
                'name' => $request->name,
                'slug' => Str::slug($request->slug),
                'description' => $request->description
            ]);

            return response()->json([
                'success' => true,
                'data' => $role,
                'message' => 'Role updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft delete the specified role.
     */
    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return response()->json([
                'success' => true,
                'message' => 'Role soft deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restore a soft-deleted role.
     */
    public function restore($id)
    {
        try {
            $role = Role::onlyTrashed()->findOrFail($id);
            $role->restore();

            return response()->json([
                'success' => true,
                'data' => $role,
                'message' => 'Role restored successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error restoring role: ' . $e->getMessage()
            ], 404);
        }
    }
}