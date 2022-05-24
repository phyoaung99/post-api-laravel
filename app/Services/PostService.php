<?php

namespace App\Services;

use App\Models\Post;
use App\Import\PostsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Contracts\Dao\PostDaoInterface;
use App\Contracts\Services\PostServiceInterface;

class PostService implements PostServiceInterface
{

  private $postDao;

  public function __construct(PostDaoInterface $postDao)
  {
    $this->postDao = $postDao;
  }

  public function index()
  {
    return $this->postDao->index();
  }

  public function store(array $data)
  {
    return $this->postDao->store($data);
  }

  public function show($id)
  {
    return $this->postDao->show($id);
  }

  public function update(array $data, $post)
  {
    return $this->postDao->update($data, $post);
  }

  public function delete($post)
  {
    return $this->postDao->delete($post);
  }

  public function search($request)
  {
    return $this->postDao->search($request);
  }

  public function import($request)
  {
        Post::truncate();
        $data = $request->file('file');
        Excel::import(new PostsImport, $data);
  }
}
