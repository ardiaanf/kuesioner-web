<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->can('viewAny', User::class)) {
            $users = User::where('id', '!=', auth()->user()->id)->get();
            return $this->successResponse(UserResource::collection($users), 'Users fetched.');
        } else {
            return $this->errorResponse('Unauthorized', ['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('create', User::class)) {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'reg_number' => 'required',
                'study_program_id' => 'required',
                'roles' => 'required|array'
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error.', $validator->errors(), 400);
            }

            if (User::where('email', $input['email'])->first()) {
                return $this->errorResponse('User already exists.', [], 400);
            }

            $user = User::create(
                [
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'reg_number' => $input['reg_number'],
                    'study_program_id' => $input['study_program_id'],
                    'password' => bcrypt($input['password']),
                    'email_verified_at' => now(),
                ]
            );

            if (isset($input['roles'])) {
                $user->syncRoles($input['roles']);
            }

            return $this->successResponse(new UserResource($user), 'User created.');
        } else {
            return $this->errorResponse('Unauthorized', ['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        if (Auth::user()->can('view', $user)) {
            return $this->successResponse(new UserResource($user), 'User fetched.');
        } else {
            return $this->errorResponse('Unauthorized', ['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if (is_null($user)) {
            return $this->errorResponse('User not found.', [], 404);
        }

        if (Auth::user()->can('update', $user)) {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required',
                'email' => 'required|email',
                'reg_number' => 'required',
                'study_program_id' => 'required',
                'roles' => 'nullable|array'
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error.', $validator->errors(), 400);
            }

            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->reg_number = $input['reg_number'];
            $user->study_program_id = $input['study_program_id'];
            $user->save();

            if (isset($input['roles'])) {
                $user->syncRoles($input['roles']);
            }

            return $this->successResponse(new UserResource($user), 'User updated.');
        } else {
            return $this->errorResponse('Unauthorized', ['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (is_null($user)) {
            return $this->errorResponse('User not found.', [], 404);
        }

        if (Auth::user()->can('delete', $user)) {
            $user->delete();
            return $this->successResponse([], 'User deleted.');
        } else {
            return $this->errorResponse('Unauthorized', ['error' => 'Unauthorized'], 401);
        }
    }
}
