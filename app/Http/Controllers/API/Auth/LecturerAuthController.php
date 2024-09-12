<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\Lecturer;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LecturerAuthController extends BaseController
{
    /**
     * Login api
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek apakah pengguna ada
        $lecturer = Lecturer::where('email', $request->email)->first();

        if (!$lecturer) {
            return $this->errorResponse('Unauthorized', ['error' => 'User not found'], 401);
        }

        // Coba autentikasi
        if (Auth::guard('lecturer')->attempt(['email' => $request->email, 'password' => $request->password])) {
            /** @var \App\Models\Lecturer $authUser **/
            $authUser = Auth::guard('lecturer')->user();
            $success['access_token'] =  $authUser->createToken('MyAuthApp')->plainTextToken;
            $success['id'] =  $authUser->id;
            $success['name'] =  $authUser->name;

            return $this->successResponse($success, 'User signed in');
        }

        return $this->errorResponse('Unauthorized', ['error' => 'Password is wrong'], 401);
    }
}
