<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class LikeController extends Controller
{
    //
    private $like;

    public function __construct(Like $like)
    {
        $this->like = $like;
    }

    public function store($post_id)
    {
        $this->like->post_id = $post_id;
        $this->like->user_id = Auth::user()->id;
        $this->like->save();

        return redirect()->back();
    }

    public function destroy($post_id)
    {
        //destory() needs id to delete, but likestable has no primary key(id)
        // so we need to use where()

        $this->like->where('post_id', $post_id)
            ->where('user_id', Auth::user()->id)
            ->delete();

        return redirect()->back();
    }
}
