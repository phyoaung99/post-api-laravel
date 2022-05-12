<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotRequest;
use App\Http\Requests\ResetRequest;
use App\Models\User;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotController extends Controller
{
    public function forgot(ForgotRequest $request)
    {
        $email = $request->forgetemail;
        $token = Str::random(10);
        try {

            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
            ]);

            Mail::send('Mails.forgot', ['token' => $token], function (Message $msg) use ($email) {
                $msg->to($email);
                $msg->subject('Reset Your Password');
            });

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
        if (!$passwordResets = DB::table('password_resets')->where('token', $token)->first()) {
            return response([
                'message' => 'Invalid Token',
            ], 400);
        }
        if (!$user = User::where('email', $passwordResets->email)->first()) {
            return response([
                'message' => 'User does not exist',
            ], 400);
        }
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return response([
            'message' => "Password Reset Successfully",
        ]);

    }
    public function resetLink($token){
        return view('users.forget-link',['token' => $token]);
    }
}
