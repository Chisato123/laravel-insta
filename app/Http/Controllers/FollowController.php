<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;

class FollowController extends Controller
{
    //
    private $follow;

    public function __construct(Follow $follow)
    {
        $this->follow = $follow;
    }

    public function store($user_id)
    {
        $this->follow->follower_id = Auth::user()->id;
        $this->follow->followed_id = $user_id;
        $this->follow->save();

        return redirect()->back();
    }

    public function destroy($user_id)
    {
        $this->follow->where('followed_id', $user_id)
            ->where('follower_id', Auth::user()->id)
            ->delete();
        //ピポットテーブルだから、follower_idとfollowed_idの両方を削除するため、whereが二つ必要。
        //whereは、データベースから特定の条件を持つレコードを検索するためのフィルタリング条件。ここでは、条件が２つある。

        return redirect()->back();
    }
}
