<?php

namespace App\Contracts\Dao;

interface AuthDaoInterface
{
  public function register(array $input);

  public function login($request);
}
