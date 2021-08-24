<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $parameter)
    {
        // dd($parameter);

        // برگرداندن اطلاعات کاربری که لاگین کرده است
        // dd(auth()->user()->toArray());

        // برگرداندن نقش کاربری که لاگین کرده است
        // dd(auth()->user()->role->toArray());


        // می گردد اولین رکوردی که با این عنوان خاص که ما فرستادیم اگه پیدا کرد برمیگرداند و
        // اگر این عنوان وجود نداشت آنگاه به ما خطا بده این عنوان داخل دسترسی ها وجود ندارد
        $permission = Permission::query()
            ->where('title', '=', $parameter)
            ->firstOrFail();



        // چک کنیم کاربری که لاگین کرده، آیا دسترسی خاصی را دارد یا خیر
        //// dd(auth()->user()->role->hasPermission($permission));



        // اگه دسترسی وجود نداشت، پیغام خطای زیر را نشان بده
        if(auth()->check() && !auth()->user()->role->hasPermission($permission))
        {
            // 403 = دسترسی برای این قسمت سایت وجود ندارد
            abort(403);
        }


        return $next($request);
    }
}
