<?php

namespace App\Dao;

use App\Models\Post;
use App\Contracts\Dao\PostDaoInterface;

class PostDao implements PostDaoInterface
{

  private $model;

  public function __construct(Post $model)
  {
    $this->model = $model;
  }

  public function index()
  {
    return $this->model->whereUserId(auth()->user()->id)->latest()->get();
  }

  public function store(array $data)
  {
    $post = $this->model->create(array_merge($data, ['user_id' => auth()->user()->id]));

    return $post;
  }

  public function show($id)
  {
    return $this->model->find($id);
  }

  public function update(array $data, $post)
  {
    if($post){
      $post->title = $data['title'];
      $post->description = $data['description'];
      $post->save();
    }
    
    return $post;
  }

  public function delete($post)
  {
    if($post){
      $post = Post::where('id',$post['id'])->delete();
    }
    return $post;
  }

  public function search($request)
  {
    $posts = $this->model->whereUserId(auth()->user()->id)->where(function ($q) use ($request) {
      if ($request->filled("text")) {
        $keyword = $request->get('text');
        $q->where("title", "LIKE", "%{$keyword}%")->orWhere("description", "LIKE", "%{$keyword}%");
      }
    })->latest()->get();

    return $posts;
  }
}
