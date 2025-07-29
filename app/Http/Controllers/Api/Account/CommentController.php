<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CommentRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewCommentNotify;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Post $post)
    {
        $userPost = auth()->user()->posts()->where("id", $post->id)->first();

        if (!$userPost) {
            return apiResponse(403, 'You are not allowed to view comments for this post');
        }

        if ($userPost->comments->count()) {
            return apiResponse(200, "post comments", CommentResource::collection($userPost->comments));
        }

        return apiResponse(404, 'No comments found for this post');
    }
    public function store(CommentRequest $request, Post $post)
    {
        $comment = $post->comments()->create([
            'user_id' => $request->user()->id,
            'comment' => $request->comment,
            'ip_address' => $request->ip()
        ]);
        if (auth()->user()->id != $post->user_id) {
            $post->user->notify(new NewCommentNotify($comment, $post));
        }
        return apiResponse(201, 'Comment Created Successfully!');
    }
}
