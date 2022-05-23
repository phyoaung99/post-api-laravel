<?php

namespace App\Contracts\Dao;


interface ForgotDaoInterface
{
public function forgot($email,$token);

public function getToken($token);

public function resetEmail($passwordResets);

public function savePassword($user, $password);

}