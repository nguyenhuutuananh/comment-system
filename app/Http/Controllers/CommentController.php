<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::with(['comments' => function ($query) {
            return $query->with(['user'])->latest()->skip(0)->take(10);
        }, 'user'])->where('parent_comment_id', null)->latest()->paginate();
        return response()->json($comments, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = Post::find($request->post_id);
        if (!$post) return response()->json(['message' => 'Bài viết không tồn tại!'], 404);
        $comment = new Comment();
        $comment->fill($request->all());
        $comment->user()->associate(auth()->user());
        $comment->commentable()->associate($post);
        $comment->save();

        // Return newest comments
        $query = Comment::latest()->with(['comments' => function ($query) {
            return $query->with(['user'])->latest()->skip(0)->take(10);
        }, 'user']);
        if ($request->last_seen_comment_id) {
            $query = $query
                    ->where('id', '>', $request->last_seen_comment_id);
        }
        $query = $query
                    ->where('parent_comment_id', $request->parent_comment_id ?? null);
        $comments = $query->get();
        $response['comments'] = $comments;
        $response['new_comment'] = $comment;
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
