<?php

namespace PYB\User\Http\Controllers\Home;

use PYB\Role\Models\Permission;
use App\Http\Controllers\Controller;
use PYB\User\Repositories\Home\UserRepo;

class UserController extends Controller
{
    public UserRepo $repo;

    public function __construct(UserRepo $userRepo)
    {
        $this->repo = $userRepo;
    }

    public function authors()
    {
        $authors = $this->repo->authors()->with('profile', 'roles')->paginate(50); // بارگذاری روابط مورد نیاز
        return view('User::Home.authors', compact('authors'));
    }

    public function author($name)
    {
        $author = $this->repo->findByName($name)->Permission(Permission::PERMISSION_AUTHORS)->first(); // تغییر نام متغیر به `author` برای خوانایی بیشتر
        if (is_null($author)) abort(404);
        return view('User::Home.author', compact('author')); // ارسال متغیر به ویو
    }
}
