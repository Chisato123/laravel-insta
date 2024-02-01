<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
  //
  private $post;
  private $category;

  public function __construct(Post $post, Category $categ)
  {
    $this->post = $post;
    $this->category = $categ;
  }

  public function create()
  {
    $all_categories = $this->category->all();

    return view('user.posts.create')
      ->with('all_categories', $all_categories);
    // view('user.posts.create')は、'user.posts.create'というビュー（表示するページ）を表示する命令です。そして、->with('all_categories', $all_categories)は、そのページに$all_categoriesという名前で全てのカテゴリ情報を渡しています。簡単に言えば、「記事を書くためのページに行くときに、カテゴリの情報も一緒に持っていくよ」ということです。
  }

  public function store(Request $request) //request have date from form(create.blade.php)
  {

    //validation rules
    $request->validate([
      'description' => 'required|max:1000',
      'image' => 'required|max:1048|mimes:jpeg,jpg,png,gif',
      'category_id' => 'required|array|between:1,3' //チェックボックスを一つ以上３つ以下に指定。
      //between = min and max items in the array
    ]);


    $this->post->description = $request->description;
    $this->post->user_id = Auth::user()->id; //Auth::user() has login date
    $this->post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
    // get the image and save on database.　これ使うと、直接データベースに保存できる。　convert image to longtext(datebaseで指定した種類)
    //colums from post_table

    $this->post->save();

    //save categorypost
    $category_post = []; //empty array
    foreach ($request->category_id as $categ_id) {
      // category_id is from form in create.blade.php(name="category_id[]")
      $category_post[] = ['category_id' => $categ_id];
    }

    // $category_post = [
    //     [
    //         'category_id' => 1,
    //         'post_id' => $this->post->id
    //     ],
    //     ['category_id' => 2],
    // ];

    $this->post->categoryPosts()->createMany($category_post);
    // categoryPosts() is  from Model
    //createMany store and save, after this $category_post has category_id,post_id

    return redirect()->route('index');
  }

  public function show($id)
  {
    $post_a = $this->post->findOrFail($id);
    // SELECT *(all) FROM posts WHERE id = $id

    return view('user.posts.show')
      ->with('post', $post_a);
  }

  // public function edit(Request $request, $id)
  // {
  // public function edit($id)
  // {
  // $post = $this->post->findOrFail($id);


  // $post->description = $request->description;
  // $post->description = $request->input('description');
  // $post->save();
  // $post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
  // $post->image = $request->image;

  //     return view('user.posts.edit')
  //         ->with('post', $post);
  // }

  public function edit($id)
  {
    //data of post
    $post_a = $this->post->findOrFail($id);

    //list of all categories
    $all_categories = $this->category->all();

    //list of selectedcategories　チェックボックスのチェックを表示
    $selected_categories = [];
    foreach ($post_a->categoryPosts as $category_post) {
      $selected_categories[] = $category_post->category_id;
    }
    // $post_aがcategory_idを持ってる状態にした。

    return view('user.posts.edit')
      ->with('post', $post_a)
      ->with('all_categories', $all_categories)
      ->with('selected_categories', $selected_categories);

    //他のファンクションでall作ったからってこっちには入らないから、またallが必要。
  }

  public function update(Request $request, $id)
  {
    //validation
    $request->validate([
      'description' => 'required|max:1000',
      'image' => 'max:1048|mimes:jpeg,jpg,png,gif',
      'category_id' => 'required|array|between:1,3'
      //storeからコピペ、imageのrequiredだけ削除
    ]);

    //find the record to update
    $post_a = $this->post->findOrFail($id);

    $post_a->description = $request->description;
    //checking if form has image
    // request->image = updateするイメージがあるかどうか
    if ($request->image) {
      $post_a->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
    }
    $post_a->save();

    //delete categoryPosts
    //categoryPosts is from Post(model)
    $post_a->categoryPosts()->delete();

    //add categoryPosts
    $category_posts = [];
    foreach ($request->category_id as $categ_id) {
      $category_posts[] = ['category_id' => $categ_id];
    }
    //category_id = colum's name
    // ['category_id'(index) => $categ_id(value)]

    $post_a->categoryPosts()->createMany($category_posts);

    return redirect()->route('post.show', $id);
  }

  public function destroy($id)
  {
    // $this->post->destroy($id);
    // OR
    // $post_a = $this->post->findOrFail($id);
    // $post_a->delete();

    $post_a = $this->post->findOrFail($id);
    // $post_a->destroy($id);
    $post_a->forceDelete();
    // forceDelete()= permenent delete , findOrFailとセットで使う。

    return redirect()->route('index');
  }
}
