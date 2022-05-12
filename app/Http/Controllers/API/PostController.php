<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use App\Export\PostsExport;
use App\Import\PostsImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::whereUserId(auth()->user()->id)->latest()->get();

        return response()->json([
            "success" => true,
            "message" => "Post List",
            "data" => $posts
        ]);
    }

    public function search(Request $request)
    {
        $posts = Post::whereUserId(auth()->user()->id)->where(function ($q) use ($request) {
            if ($request->filled("text")) {
                $keyword = $request->get('text');
                $q->where("title", "LIKE", "%{$keyword}%")->orWhere("description", "LIKE", "%{$keyword}%");
            }
        })->latest()->get();

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
        $post = Post::create(array_merge($input, ['user_id' => auth()->user()->id]));
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
        $post = Post::find($id);
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
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $post->title = $input['title'];
        $post->description = $input['description'];
        $post->save();
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
        $post->delete();
        return response()->json([
            "success" => true,
            "message" => "post deleted successfully.",
            "data" => $post
        ]);
    }

    public function import(Request $request)
    {
        Post::truncate();
        $data = $request->file('file');
        Excel::import(new PostsImport, $data);
        return response()->json([
            "success" => true,
            "message" => "post csv import successfully.",
        ]);
    }
}
