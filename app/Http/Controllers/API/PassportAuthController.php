<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Contracts\Services\AuthServiceInterface;

class PassportAuthController extends Controller
{
    private $authService;
    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }
    /**
     * Registration Req
     */
    public function register(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        try {
            if ($validator->fails()) {
                return response([
                    'error' => $validator->errors()
                ]);
            }
            $user = $this->authService->register($input);

            $token = $user->createToken('Laravel8PassportAuth')->plainTextToken;
            return response()->json([
                'token' => $token
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e
            ]);
        }
    }

    /**
     * Login Req
     */
    public function login(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => 422
            ]);
        }
        $data = $this->authService->login($request);
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('Laravel8PassportAuth')->plainTextToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function registerPage()
    {
        return view('users.register');
    }

    public function loginPage()
    {
        return view('users.login');
    }

    public function userInfo()
    {
        $user = auth()->user();
        
        return response()->json(['user' => $user], 200);
    }

    public function logout()
    {
        Auth::logout();
        return response([
            'message' => 'User Logout Successfully'
        ]);
    }
}
