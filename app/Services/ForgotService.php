<?php

namespace App\Services;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use App\Contracts\Dao\ForgotDaoInterface;
use App\Contracts\Services\ForgotServiceInterface;

class ForgotService implements ForgotServiceInterface
{
  private $forgotDao;

  public function __construct(ForgotDaoInterface $forgotDao)
  {
    $this->forgotDao = $forgotDao;
  }

  public function forgot($email, $token)
  {
    return $this->forgotDao->forgot($email, $token);
  }

  public function mailSend($email,$token)
  {
    return Mail::send('Mails.forgot', ['token' => $token], function (Message $msg) use ($email) {
      $msg->to($email);
      $msg->subject('Reset Your Password');
  });
  }

  public function getToken($token)
  {
    return $this->forgotDao->getToken($token);
  }

  public function resetEmail($passwordResets)
  {
    return $this->forgotDao->resetEmail($passwordResets);
  }

  public function savePassword($user, $password)
  {
    return $this->forgotDao->savePassword($user, $password);
  }
}
