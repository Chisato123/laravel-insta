<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; //indexの時に追加
use Illuminate\Support\Facades\Auth;
use App\Models\User; //suggested_usersの時に追加

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $post; //indexの時に追加
    private $user; //suggested_usersの時に追加

    public function __construct(Post $post, User $user)
    {
        // $this->middleware('auth');
        $this->post = $post;
        $this->user = $user; //suggested_usersの時に追加

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // return view('home');

        if ($request->search) {
            //search data
            $home_posts = $this->post->where('description', 'LIKE', '%' . $request->search . '%')->latest()->get();
            //where はフィルター
            // SELECT * FROM posts WHERE description LIKE '%farm%'
            // regex/regular expression
            // % = any character (number or letter)
            // search is from app.blade(input name="search")
        } else {
            //通常のindexをelse内に入れた。
            $all_posts = $this->post->latest()->get();

            $home_posts = []; //empty arrayが最終的に表示されるリストになるから、必要。
            foreach ($all_posts as $p) {
                if ($p->user_id == Auth::user()->id || $p->user->isFollowed()) {
                    $home_posts[] = $p;
                }
            }
        }

        //最初に全部のデータ取得して、all_postsで空の入れ物作って、foreachのフィルターを通して、空っぽの入れ物に追加していく感じ。

        // $all_posts = []; emptyが表示されるか確認した時に使用。

        $suggested_users = array_slice($this->suggested_users(), 0, 10);
        //右のsuggested_usersは下のfunctionを呼び出している。

        return view('user.index')
            ->with('all_posts', $home_posts)
            ->with('suggested_users', $this->suggested_users())
            ->with('search', $request->search);
    }

    private function suggested_users()
    {
        $suggested_users = [];

        //get all users expect logged-in users
        $all_users = $this->user->all()->except(Auth::user()->id);
        foreach ($all_users as $u) {
            if (!$u->isFollowed()) {
                $suggested_users[] = $u;
            }
        }

        return $suggested_users;
    }
}
