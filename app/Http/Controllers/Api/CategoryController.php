<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\PostCollection;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $categories = Category::active()->get();
        if(!$categories){
            return $this->apiResponse(404 , 'No Categories');
        }
        return $this->apiResponse(200 , 'All Categories' , new CategoryCollection($categories));
    }
    public function getCategoryPosts(Category $category)
    {
        if(!$category){
            return $this->apiResponse(404 , 'Category Not Found');
        }
        return $this->apiResponse(200 , 'This is Category Posts' , new PostCollection($category->posts));
    }
}
