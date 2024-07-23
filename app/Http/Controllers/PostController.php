<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Jobs\TestJob;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use DatePeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // default values
        $skip = 0;
        $perPage = 100;
        $currentPage = 1;

        // if user sets specific perPage
        if ($request->perPage) {
            $perPage = (int)$request->perPage;
        }

        // if user sets specific page
        if ($request->page) {
            $currentPage = (int)$request->page;
            $skip = (int) $perPage * ($currentPage - 1);
        }

        $posts = Post::skip($skip)->limit($perPage)->with('user')->get();

        return response()->json([
            'message' => '',
            'current_page' => $currentPage,
            'per_page' => $perPage,
            'data' => $posts,
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {

        $post = new Post;

        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = auth()->user()->id;

        $post->save();

        return response()->json([
            'message' => 'Post Created',
            'data' => $post,
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);

        return response()->json([
            'message' => '',
            'data' => new PostResource($post)
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $comments = $post->comments;

        foreach ($comments as $comment) {
            $comment->delete();
        }
        $post->delete();
    }
}
