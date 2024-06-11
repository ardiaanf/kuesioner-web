<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\Student;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAuthController extends BaseController
{
    /**
     * Login api
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(Request $request)
    {
        if (!Student::where('email', $request->email)->exists()) {
            return $this->errorResponse('Unauthorized', ['error' => 'User not found'], 401);
        }

        if (Auth::guard('student')->attempt(['email' => $request->email, 'password' => $request->password])) {
            /** @var \App\Models\Student $authUser **/
            $authUser = Auth::guard('student')->user();
            $success['access_token'] =  $authUser->createToken('MyAuthApp')->plainTextToken;
            $success['id'] =  $authUser->id;
            $success['name'] =  $authUser->name;

            return $this->successResponse($success, 'User signed in');
        } else if (Student::where('email', $request->email)->first()->password != $request->password) {
            return $this->errorResponse('Unauthorized', ['error' => 'Password is wrong'], 401);
        } else {
            return $this->errorResponse('Unauthorized', [], 401);
        }
    }
}
