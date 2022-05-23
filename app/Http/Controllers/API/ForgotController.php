<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use App\Http\Requests\ResetRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotRequest;
use App\Contracts\Services\ForgotServiceInterface;

class ForgotController extends Controller
{
    private $forgotService;
    public function __construct(ForgotServiceInterface $forgotService)
    {
        $this->forgotService = $forgotService;
    }

    public function forgot(ForgotRequest $request)
    {
        $email = $request->forgetemail;
        $token = Str::random(10);
        try {

            $this->forgotService->forgot($email, $token);

            $this->forgotService->mailSend($email, $token);

            return response([
                'message' => "check your email",
            ]);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    public function reset(ResetRequest $request)
    {
        $token = $request->input('token');
        $data = $this->forgotService->getToken($token);

        if (!$passwordResets = $data) {
            return response([
                'message' => 'Invalid Token',
            ], 400);
        }

        $resetEmail = $this->forgotService->resetEmail($passwordResets);
        if (!$user = $resetEmail) {
            return response([
                'message' => 'User does not exist',
            ], 400);
        }
        $password = $request->input('password');

        $user = $this->forgotService->savePassword($user, $password);

        return response([
            'message' => "Password Reset Successfully",
        ]);
    }
    public function resetLink($token)
    {
        return view('users.forget-link', ['token' => $token]);
    }
}
