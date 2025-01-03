<?php

namespace PYB\Article\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use PYB\Article\Repositories\ArticleRepo;
use PYB\Comment\Repositories\CommentRepo;
use PYB\Home\Repositories\HomeRepo;

class ArticleController extends Controller
{
    public ArticleRepo $repo;

    public function __construct(ArticleRepo $articleRepo)
    {
        $this->repo = $articleRepo;
    }

       public function home(CommentRepo $commentRepo)
       {
           $articles = $this->repo->index()->paginate(6);
           $viewsArticles = $this->repo->getArticlesByViews()->latest()->limit(5)->get();
           $latestComments = $commentRepo->getLatestComments()->limit(3)->get();

           return view('Article::Home.home', compact('articles', 'viewsArticles', 'latestComments'));
       }

    public function details($slug, HomeRepo $homeRepo, CommentRepo $commentRepo)
    {
        $article = $this->repo->findBySlug($slug);

        if (is_null($article)) abort(404);
        $relatedArticles = $this->repo->relatedArticles($article->category_id, $article->id)->limit(3)->get();
        $latestComments = $commentRepo->getLatestComments()->limit(3)->get();


        return view('Article::Home.details', compact(['article', 'relatedArticles', 'homeRepo' ,'latestComments']));
    }
}
