<?php

namespace PYB\Article\Http\Controllers\Admin;

use Illuminate\Http\Request;
use PYB\Article\Models\Article;
use App\Http\Controllers\Controller;
use PYB\Article\Requests\ArticleRequest;
use PYB\Article\Services\ArticleService;
use PYB\Article\Repositories\ArticleRepo;
use PYB\Category\Repositories\CategoryRepo;

class ArticleController extends Controller
{
    private string $class = Article::class;

    public ArticleRepo $repo;
    public ArticleService $service;

    public function __construct(ArticleRepo $articleRepo, ArticleService $articleService)
    {
        $this->repo = $articleRepo;
        $this->service = $articleService;
    }

    public function index()
    {
        $this->authorize('manage', $this->class);
        $articles = $this->repo->index()->paginate(10);

        return view('Articel::Admin.index', compact('articles'));
    }

    public function create(CategoryRepo $categoryRepo)
    {
        $this->authorize('manage', $this->class);
        $categories = $categoryRepo->getActiveCategories()->get();

        return view('Articel::Admin.create', compact('categories'));
    }

    public function store(ArticleRequest $request)
    {
        $this->authorize('manage', $this->class);

        [$imageName, $imagePath] = $this->service->uploadImage($request->file('image'));

        $this->service->store($request, auth()->id(), $imageName, $imagePath);

        alert()->success('ساخت مقاله', 'عملیات با موفقیت انجام شد');
        return to_route('articles.index');
    }

    public function edit($id, CategoryRepo $categoryRepo)
    {
        $this->authorize('manage', $this->class);
        $article = $this->repo->findById($id);
        $categories = $categoryRepo->getActiveCategories()->get();

        return view('Articel::Admin.edit', compact(['article', 'categories']));
    }

    public function update(ArticleRequest $request, $id)
    {
        $this->authorize('manage', $this->class);

        $file = $request->file('image');
        $article = $this->repo->findById($id);

        [$imageName, $imagePath] = $this->uploadImage($file, $article);

        $this->service->update($request, $id, $imageName, $imagePath);

        alert()->success('ویرایش مقاله', 'عملیات با موفقیت انجام شد');
        return to_route('articles.index');
    }

    public function destroy($id)
    {
        $this->authorize('manage', $this->class);

        $article = $this->repo->findById($id);
        $this->service->deleteImage($article);
        $this->repo->delete($id);

        alert()->success('حذف مقاله', 'عملیات با موفقیت انجام شد');
        return to_route('articles.index');
    }

    private function uploadImage($file, $article): array
    {
        if (!is_null($file)) {
            [$imageName, $imagePath] = $this->service->uploadImage($file);
        } else {
            $imageName = $article->imageName;
            $imagePath = $article->imagePath;
        }

        return array($imageName, $imagePath);
    }
}
