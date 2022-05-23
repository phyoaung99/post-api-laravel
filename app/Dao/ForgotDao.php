<?php

namespace App\Dao;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Contracts\Dao\ForgotDaoInterface;

class ForgotDao implements ForgotDaoInterface
{
  public function forgot($email, $token)
  {
    $data = DB::table('password_resets')->insert([
      'email' => $email,
      'token' => $token,
    ]);
    return $data;
  }

  public function getToken($token)
  {
    return DB::table('password_resets')->where('token', $token)->first();
  }

  public function resetEmail($passwordResets)
  {
    return User::where('email', $passwordResets->email)->first();
  }

  public function savePassword($user, $password)
  {
    $user->password = Hash::make($password);
    $user->save();

    return $user;
  }
}
