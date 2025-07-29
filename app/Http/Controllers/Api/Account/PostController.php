<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\PostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use App\Utils\ImageManger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = auth()->user()->posts()->active()->activeCategory()->get();
        if (!count($posts)) {
            return apiResponse(404, 'No Posts To this User');
        }
        return apiResponse('200', 'This is user Posts', new PostCollection($posts));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        DB::beginTransaction();
        try {
            $post = auth()->user()->posts()->create($request->except(['images']));
            ImageManger::uploadImages($request, $post);
            DB::commit();
            Cache::forget('read_more_posts');
            Cache::forget('latest_posts');

            return apiResponse(201, 'Post Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Store User Post : ' . $e->getMessage());
            return apiResponse(400, 'Bad Request');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return apiResponse('200', 'User post', new PostResource($post));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        try {
            DB::beginTransaction();

            $post->update($request->except(['images']));

            if ($request->hasFile('images')) {
                ImageManger::deleteImages($post);
                ImageManger::uploadImages($request, $post);
            }
            DB::commit();
            return apiResponse(200, 'Post Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Update User Post', $e->getMessage());
            return apiResponse(400, 'try again latter!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        ImageManger::deleteImages($post);
        $post->delete();
        return apiResponse(200, 'Post Deleted Successfully!');
    }
}
