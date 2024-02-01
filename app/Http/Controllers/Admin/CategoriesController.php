<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
// use App\Models\CategoryPost;
use App\Models\Post;

class CategoriesController extends Controller
{
    //
    private $post;
    private $category;

    public function __construct(Post $post, Category $category)
    {

        $this->post = $post;
        $this->category = $category; //$this->category = new Category();
    }

    public function index()
    {
        $all_categories = $this->category->orderBy('id')->paginate(10);

        $all_posts = $this->post->all();
        $uncategorized_count = 0;
        foreach ($all_posts as $p) {

            if ($p->categoryPosts->count() == 0) {
                $uncategorized_count++;
            }
        }

        return view('admin.categories.index')
            ->with('all_categories', $all_categories)
            ->with('uncategorized_count', $uncategorized_count);
        // ->with('categoryCounts', $categoryCounts);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:50|unique:categories,name'
            ]
        );
        // $this->category->name = $request->input('name'); これでもOK
        $this->category->name = $request->name;
        $this->category->save();

        // return redirect()->back(); これでもOK
        return redirect()->route('admin.categories');
    }

    public function destroy($id)
    {
        // $this->category->findOrFail($id)->forceDelete(); これでもOK
        // $category_a = $this->category->findOrFail($id);
        // $category_a->forceDelete();
        $this->category->destroy($id);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {

        $request->validate(
            [
                'categ_name' => 'required|max:50|unique:categories,name,' . $id
            ]
        );

        $category_a = $this->category->findOrFail($id);

        // $category_a->name = $request->name;
        $category_a->name = $request->input('categ_name');
        // categ_nameはinputタグのnameと一致する必要がある。line73も。シンプルにnameで全部いけた。inputもなくても大丈夫だった。
        $category_a->save();

        return redirect()->back();
    }
}
