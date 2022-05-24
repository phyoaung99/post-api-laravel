<?php

namespace App\Contracts\Services;

interface PostServiceInterface {
  
  public function index();

  public function store(array $data);

  public function show($id);

  public function update(array $data, $post);

  public function delete($post);

  public function search($request);

  public function import($request);
}