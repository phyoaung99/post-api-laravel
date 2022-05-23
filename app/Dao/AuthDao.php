<?php

namespace App\Dao;

use App\Contracts\Dao\AuthDaoInterface;
use App\Models\User;

class AuthDao implements AuthDaoInterface
{
  public function register(array $input)
  {
    if($input){
      $user = User::create([
        'name' => $input['name'],
        'email' => $input['email'],
        'password' => bcrypt($input['password'])
      ]);
    }
    return $user;
  }

  public function login($request)
  {
      $data = [
        'email' => $request->email,
        'password' => $request->password
      ];

    return $data;
  }
}
