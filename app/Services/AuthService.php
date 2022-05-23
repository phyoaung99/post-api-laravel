<?php

namespace App\Services;

use App\Contracts\Dao\AuthDaoInterface;
use App\Contracts\Services\AuthServiceInterface;

class AuthService implements AuthServiceInterface
{
  private $authDao;

  public function __construct(AuthDaoInterface $authDao)
  {
    $this->authDao = $authDao;
  }

  public function register(array $input)
  {
    return $this->authDao->register($input);
  }

  public function login($request)
  {
    return $this->authDao->login($request);
  }
}
