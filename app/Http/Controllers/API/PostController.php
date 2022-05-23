<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Contracts\Services\PostServiceInterface;

class PostController extends Controller
{
    private $postService;
    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postService->index();

        return response()->json([
            "success" => true,
            "message" => "Post List",
            "data" => $posts
        ]);
    }

    public function search(Request $request)
    {
        $posts = $this->postService->search($request);

        return response()->json([
            "success" => true,
            "message" => "Post List",
            "data" => $posts
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors()
            ]);
        }

        $post = $this->postService->store($input);

        return response()->json([
            "success" => true,
            "message" => "post created successfully.",
            "data" => $post
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->postService->show($id);
        if (is_null($post)) {
            return $this->sendError('post not found.');
        }
        return response()->json([
            "success" => true,
            "message" => "post retrieved successfully.",
            "data" => $post
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors()
            ]);
        }

        $post = $this->postService->update($input, $post);

        return response()->json([
            "success" => true,
            "message" => "post updated successfully.",
            "data" => $post
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post = $this->postService->delete($post);

        return response()->json([
            "success" => true,
            "message" => "post deleted successfully.",
            "data" => $post
        ]);
    }

    public function import(Request $request)
    {
        $this->postService->import($request);

        return response()->json([
            "success" => true,
            "message" => "post csv import successfully.",
        ]);
    }
}
