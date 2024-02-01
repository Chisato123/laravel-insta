<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class ProfileController extends Controller
{
    //
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show($id)
    {
        $user_a = $this->user->findOrFail($id);
        return view('user.profile.show')->with('user', $user_a);
    }

    public function edit()
    {
        // no $id for edit、ログインしてすでにどのidかわかっているから。
        // だから、routeにもidいらない。
        return view('user.profile.edit');
    }

    public function update(Request $request)
    {
        //validation
        $request->validate([
            'avatar' => 'max:1048|mimes:jpeg,jpg,png,gif',
            'name' => 'required|max:50',
            'introduction' => 'max:100',
            'email' => 'required|max:50|email|unique:users,email,' . Auth::user()->id
            // unique:users,email = tablename,columnname
            // users,email,1 | [table name],[column name],[id]
            // use exception例外 (id) when updating, but not when creating new record
            //(when creating > unique:users,email)
        ]);

        // update profile
        $user_a = $this->user->findOrFail(Auth::user()->id);

        $user_a->name = $request->name;
        $user_a->introduction = $request->introduction;
        $user_a->email = $request->email;

        if ($request->avatar) {
            $user_a->avatar = 'data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
        }

        // ifがないとextension() on nullになる。
        // $user_a->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));

        $user_a->save();
        return redirect()->route('profile.show', Auth::user()->id);
        // return view('user.profile.show')->with('user', $user_a);
    }

    public function following($id)
    {
        $user_a = $this->user->findOrFail($id);
        return view('user.profile.following')->with('user', $user_a);
    }

    public function followers($id)
    {
        $user_a = $this->user->findOrFail($id);
        return view('user.profile.followers')->with('user', $user_a);
    }

    public function updatePassword(Request $request)
    {
        // That is not your current password
        $user_a = $this->user->findOrFail(Auth::user()->id);
        if (!Hash::check($request->old_password, $user_a->password)) { // if not current password
            // send error message
            return redirect()->back()->with('incorrect_password_error', 'That is not your current password.');
        }

        //new password cannot be same as current password
        if ($request->old_password == $request->new_password) {
            // send error message
            return redirect()->back()->with('same_password_error', 'New password cannot be the same as current password.');
        }
        // new password does not matct = normal validation使える。上二つは無理
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed'
            //confirm - match 2 inputs with similar names ( ×and ×confirmation)
        ]);

        $user_a->password = Hash::make($request->new_password);
        $user_a->save();

        return redirect()->back()->with('password_change_success', 'Changed password successfully!');
    }
}
