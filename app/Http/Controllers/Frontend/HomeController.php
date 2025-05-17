<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $posts = Post::active()->with('images')->latest()->paginate(9);
        $most_posts_views = Post::active()->orderBy('num_of_views', 'desc')->limit(3)->get();
        $oldest_news = Post::active()->oldest()->take(3)->get();
        $popular_posts = Post::active()->withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->take(3)
            ->get();
        $categories_with_posts = Category::with(['posts' => function ($q) {
            $q->active()->limit(4);
        }])
            ->has('posts', '>=', 2)
            ->active()
            ->get();

        return view('frontend.index',
            compact('posts', 'most_posts_views', 'oldest_news', 'popular_posts', 'categories_with_posts'));
    }
}
