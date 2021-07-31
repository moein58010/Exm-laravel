<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        return view('categories.index',[
            'categories' => Category::all()
        ]);
    }


    public function create()
    {
        return view('categories.create');
    }

    public function store(NewCategoryRequest $request)
    {
// ذخیره دسته بندی
        Category::query()->create([
           'title' => $request->get('title')
        ]);

        return redirect('/');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', [
           'category' => $category
        ]);
    }


    public function update(UpdateCategoryRequest $request, Category $category)
    {

        // داخل جدول  category می گردیم که آیا این عنوان قبلا استفاده شده و یا نه و اگه استفاده شده باید برای پستی غیر از پستی که در حال حاضر در حال ویرایش اش هستیم، استفاده شده باشد و اگه نه ارور لازم نیست
        // اگه عنوان فرستاده شده فقط برای پست فعلی وجود داره آنگاه نباید خطای یکتا نبودن عنوان را نشان بدهد
        $titleExists = Category::query()->where('title', $request->get('title'))
// آیدی برابر نباشد با آیدی پست فعلی مون
            ->where('id', '!=', $category->id)
            ->exists();


        if($titleExists)
        {
// به صفحه ی قبلی بازگرد و خطای ما را هم اعلان کن
            return redirect()->back()->withErrors(['title' => 'the title already been taken']);
        }


        $category->update([
           'title' => $request->get('title')
        ]);

        return redirect('/categories');
    }


    public function destroy(Category $category)
    {
// اگه تعداد پست هایش بزرگتر از 0 بود آنگاه آن را به صفحه ی قبل با خطای مربوطه بر می گردانیم در غیر این صورت آن را پاک می کنیم
        if ($category->posts->count() > 0)
        {
            return back()->withErrors(['category can not be deleted']);
        }

        $category->delete();

        return redirect('/categories');
    }

}
