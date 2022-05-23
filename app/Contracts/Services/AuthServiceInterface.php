<?php

namespace App\Contracts\Services;

interface AuthServiceInterface
{
  public function register(array $input);

  public function login($request);
}
