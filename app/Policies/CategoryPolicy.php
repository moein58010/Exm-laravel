<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use App\Models\category;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->hasPermission('read-category');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\category  $category
     * @return mixed
     */
    public function view(User $user, category $category)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->hasPermission('create-category');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\category  $category
     * @return mixed
     */
    public function update(User $user, category $category)
    {
        $isAuthorized =  $user->role->hasPermission('update-category')
            && !empty($category);


        return $isAuthorized
            ? Response::allow()
            : Response::deny('شما مجاز نیستید');

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\category  $category
     * @return mixed
     */
    public function delete(User $user, category $category)
    {
        return $user->role->hasPermission('delete-category')
            && !empty($category)
            && $category->posts()->count() == 0;

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\category  $category
     * @return mixed
     */
    public function restore(User $user, category $category)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\category  $category
     * @return mixed
     */
    public function forceDelete(User $user, category $category)
    {
        //
    }
}
