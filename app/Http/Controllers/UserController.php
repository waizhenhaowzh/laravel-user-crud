<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // =========================
    // 1. LIST USERS (with filter + pagination)
    // GET /api/users
    // =========================
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        return response()->json([
            'data' => $query->paginate(10)
        ]);
    }

    // =========================
    // 2. CREATE USER
    // POST /api/users
    // =========================
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|unique:users',
            'password' => 'required|min:6',
            'status' => 'required|in:active,inactive',
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user
        ]);
    }

    // =========================
    // 3. SHOW SINGLE USER
    // GET /api/users/{user}
    // =========================
    public function show(User $user)
    {
        return response()->json($user);
    }

    // =========================
    // 4. UPDATE USER
    // PUT /api/users/{user}
    // =========================
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'phone_number' => 'sometimes|unique:users,phone_number,' . $user->id,
            'status' => 'sometimes|in:active,inactive',
        ]);

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }

    // =========================
    // 5. DELETE USER (soft delete)
    // DELETE /api/users/{user}
    // =========================
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }

    // =========================
    // 6. BULK DELETE
    // DELETE /api/users
    // =========================
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids; // expects: [1,2,3]

        User::whereIn('id', $ids)->delete();

        return response()->json([
            'message' => 'Users deleted successfully'
        ]);
    }

    // =========================
    // 7. EXPORT (simple JSON export)
    // GET /api/users-export
    // =========================
    public function export()
    {
        $users = User::all();

        return response()->json([
            'data' => $users
        ]);
    }
}