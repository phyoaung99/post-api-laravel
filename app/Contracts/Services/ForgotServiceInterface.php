<?php

namespace App\Contracts\Services;

interface ForgotServiceInterface
{
  public function forgot($email, $token);

  public function mailSend($email, $token);

  public function getToken($token);

  public function resetEmail($passwordResets);

  public function savePassword($user, $password);
}
