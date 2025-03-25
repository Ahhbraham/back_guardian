<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::all();
            if ($roles->count() > 0) {
                return response()->json([$roles], 200);
            } else {
                return "No role was found";
            }
        } catch (\Exception $e) {
            return response()->json(["Error" => "Error Fetching Roles"], 500);
        }
    }

    // Create Role function
    public function CreateRole(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "slug" => "required|string|max:255|unique:roles",
            "description" => "nullable|string|max:1000",
        ]);

        try {
            $role = new Role();
            $role->name = $request->name;
            $role->slug = $request->slug;
            $role->description = $request->description;

            $createdRole = $role->save();
            if ($createdRole) {
                return "Role Created Successfully";
            } else {
                return "Role Not Created!";
            }
        } catch (\Exception $e) {
            return response()->json(["Error" => "Error Creating Role"], 500);
        }
    }

    // Read Role function
    public function getRole($id)
    {
        try {
            $fetchedRole = Role::findOrFail($id);

            if ($fetchedRole) {
                return response()->json($fetchedRole);
            } else {
                return "Role was not found for ID: `$id`";
            }
        } catch (\Exception $e) {
            return response()->json(["Error" => "Error Fetching Role"], 401);
        }
    }

    // Update function
    public function updateRole(Request $request, $id)
    {
        try {
            $roleToUpdate = Role::findOrFail($id);

            if ($roleToUpdate) {
                $roleToUpdate->name = $request->name; // Fixed assignment syntax
                $roleToUpdate->slug = $request->slug; // Fixed assignment syntax
                $roleToUpdate->description = $request->description; // Fixed assignment syntax

                $updatedRole = $roleToUpdate->save();
                if ($updatedRole) {
                    return response()->json($roleToUpdate, 201); // Fixed variable name
                } else {
                    return "Role was Not Updated for ID: `$id`";
                }
            }
        } catch (\Exception $e) {
            return response()->json(["Error" => "Error Updating Role"], 401);
        }
    }

    // Delete function
    public function deleteRole($id)
    {
        try {
            $roleToDelete = Role::findOrFail($id);

            if ($roleToDelete) {
                $deletedRole = $roleToDelete->delete(); // Fixed deletion syntax

                if ($deletedRole) {
                    return "Role has been deleted";
                } else {
                    return "Role was not deleted";
                }
            }
        } catch (\Exception $e) {
            return "Error deleting the record";
        }
    }
}