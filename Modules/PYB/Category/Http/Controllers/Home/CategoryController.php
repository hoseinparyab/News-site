<?php

namespace PYB\Category\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use PYB\Article\Repositories\ArticleRepo;
use PYB\Category\Repositories\CategoryRepo;

class CategoryController extends Controller
{

    public function details($slug, CategoryRepo $categoryRepo ,ArticleRepo $articleRepo)
    {
        $category = $categoryRepo->findBySlug($slug);
        if (is_null($category)) abort(404);
        $articles = $articleRepo->getarticlesByCategoryId($category->id)->paginate(12);


        return view('Category::Home.details', compact(['category', 'articles']));

    }
}
