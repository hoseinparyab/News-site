<?php

namespace PYB\Article\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use PYB\Role\Models\Permission;
use PYB\User\Models\User;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function manage(User $user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_ARTICLES)) {
            return true;
        }
    }
}
