<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded = [];

    // نقش تعداد زیادی می تواند دسترسی داشته باشد
    public function permissions()
    {
        // N to N
        return $this->belongsToMany(Permission::class);
    }


    /**
     * @param Permission $permission
     * @return bool
     */
    public function hasPermission(Permission $permission)
    {
        return $this->permissions()
            ->where('permission_id', $permission->id)
            ->exists();
    }
}