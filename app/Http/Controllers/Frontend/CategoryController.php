<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Category $category)
    {
        if (!$category) {
            return redirect()->back()->with('warning', 'Try again latter!');
        }
        $posts = $category->posts()->paginate(9);
        $other_categories = Category::active()
            ->where('id', '!=', $category->id)
            ->get(['id', 'name', 'slug']);

        return view('frontend.category-posts', compact('posts', 'category', 'other_categories'));
    }
}
