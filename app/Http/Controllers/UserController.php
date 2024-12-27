<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreate;
use App\Http\Requests\UserUpdate;
use App\Services\UserService;
use Illuminate\Http\Request;
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $users = $this->userService->fetchAllUsers();
            return response()->json(['success' => true, 'data' => $users], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function store(UserCreate $request)
    {
        try {
            $data = $request->validated();
            $user = $this->userService->createUser($data);

            return response()->json(['success' => true, 'data' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = $this->userService->getUserById($id);

            if ($user) {
                return response()->json(['success' => true, 'data' => $user], 200);
            }

            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function update(UserUpdate $request, $id)
    {
        try {
            $data = $request->validated();
            $user = $this->userService->updateUser($id, $data);

            if ($user) {
                return response()->json(['success' => true, 'data' => $user], 200);
            }

            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $deleted = $this->userService->deleteUser($id);

            if ($deleted) {
                return response()->json(['success' => true, 'message' => 'User deleted'], 200);
            }

            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $filters = $request->only(['name', 'surname', 'email', 'phone', 'company_name']);
            $users = $this->userService->searchUsers($filters);

            return response()->json(['success' => true, 'data' => $users], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
