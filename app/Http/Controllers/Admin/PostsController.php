<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostsController extends Controller
{
    //
    private $post;
    private $category;


    public function __construct(Post $post, Category $categ)
    {
        $this->post = $post;
        $this->category = $categ;
    }

    // public function index()
    // {
    // $all_posts = $this->post->orderBy('created_at', 'desc')->withTrashed()->paginate(10);
    // $all_posts = $this->post->get();

    // $all_categories = $this->category->all();


    //     return view('admin.posts.index')->with('all_posts', $all_posts)
    //         ->with('all_categories', $all_categories);
    // }

    public function index(Request $request)
    {
        if ($request->search) {
            $all_posts = $this->post->where('description', 'LIKE', '%' . $request->search . '%')->withTrashed()->paginate(3);
            $all_categories = $this->category->all();
            $post_a = $this->post;

            $selected_categories = [];
            foreach ($post_a->categoryPosts as $category_post) {
                $selected_categories[] = $category_post->category_id;
            }
        } else {

            $all_posts = $this->post->withTrashed()->latest()->paginate(3);
            // $all_posts = $this->post;
            //withTrashed()使った時に、latestがないとエラーになった。

            $post_a = $this->post;

            $all_categories = $this->category->all();
            $selected_categories = [];
            foreach ($post_a->categoryPosts as $category_post) {
                $selected_categories[] = $category_post->category_id;
            }
        }

        return view('admin.posts.index')->with('all_posts', $all_posts)
            ->with('all_categories', $all_categories)
            ->with('selected_categories', $selected_categories)
            ->with('search', $request->search);
    }

    public function hide($id)
    {
        // soft delete
        $this->post->destroy($id);

        return redirect()->back();
    }

    public function restore($id)
    {

        $this->post->onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back();
    }
}
