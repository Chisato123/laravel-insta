<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Comment;

class CommentController extends Controller
{
    //
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function store(Request $request, $post_id)
    {
        //validation
        $request->validate(
            [
                'comment_body' . $post_id => 'required|max:150'
                // comment_body is from create view
            ],
            [
                //comment_body6.required
                //commentの内容をここで変更している。to custom the message
                'comment_body' . $post_id . '.required' => 'Comment cannot be empty',
                'comment_body' . $post_id . '.max' => 'You can only have 150 characters'
            ]
        );
        $this->comment->body = $request->input('comment_body' . $post_id);
        // ->nameの代わりにinput使える。form has Number so we can use input
        $this->comment->post_id = $post_id;
        $this->comment->user_id = Auth::user()->id;
        $this->comment->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        // パターン１
        $comment = $this->comment->findOrFail($id);
        $comment->delete();

        // パターン２
        // $this->comment->destroy($id);
        return redirect()->back();
    }
}
