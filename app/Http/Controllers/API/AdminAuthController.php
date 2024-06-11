<?php

namespace App\Http\Controllers\API;

use App\Models\Admin;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends BaseController
{
    /**
     * Login api
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(Request $request)
    {
        if (!Admin::where('email', $request->email)->exists()) {
            return $this->errorResponse('Unauthorized', ['error' => 'User not found'], 401);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            $success['access_token'] =  $authUser->createToken('MyAuthApp')->plainTextToken;
            $success['id'] =  $authUser->id;
            $success['name'] =  $authUser->name;

            return $this->successResponse($success, 'User signed in');
        } else if (Admin::where('email', $request->email)->first()->password != $request->password) {
            return $this->errorResponse('Unauthorized', ['error' => 'Password is wrong'], 401);
        } else {
            return $this->errorResponse('Unauthorized', ['error' => 'Unauthorized'], 401);
        }
    }
}
