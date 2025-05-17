<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\CommentRequest;
use App\Models\Post;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Notifications\NewCommentNotify;

class PostController extends Controller
{
    public function show(Post $post)
    {
        $mainPost = $post->load(['comments' => function ($q) {
            $q->latest()->limit(3);
        }]);
        $mainPost->increment('num_of_views');
        $posts = $mainPost->category->posts()
            ->select('id', 'slug', 'title')
            ->where('id', '!=', $post->id)
            ->active()
            ->limit(5)
            ->get();
        return view('frontend.show', compact('mainPost', 'posts'));
    }

    public function getAllComments(Post $post)
    {
        return response()->json($post->comments()->with('user')->latest()->get());
    }

    public function saveComment(CommentRequest $request)
    {
        $comment = Comment::create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'post_id' => $request->post_id,
            'ip_address' => $request->ip(),
        ]);
        if (!$comment) {
            return response()->json([
                'message' => 'Operation failed',
                'status' => 500,
            ]);
        }
        $post = Post::findOrFail($request->post_id);
        if (auth()->user()->id != $post->user_id) {
            $post->user->notify(new NewCommentNotify($comment, $post));
        }
        $comment->load('user');
        return response()->json([
            'msg' => 'Comment Stored Successfully!',
            'comment' => $comment,
            'status' => 201,
        ]);
    }
}
