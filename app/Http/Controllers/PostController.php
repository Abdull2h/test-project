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
        $posts = Post::where(function($q) use ($request){
            if ($request->user_id != null) {
                $q->where('user_id',$request->user_id);
            }
        })->limit(10)->get();

        // $posts = Post::with('user')->whereHas('user',function($q){
        //     $q->where('email','aa@aa.com');
        // })->limit(10000)->get();

        // $posts = Post::paginate($request->perPage);

        return response()->json([
            'message' => '',
            'data' => $posts,
            // 'data' => PostResource::collection($posts),
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
