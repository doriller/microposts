<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UsersController extends Controller
{
    public function index()
    {
        // ユーザ一覧をidの降順で取得
        $users = User::orderBy('id', 'desc')->paginate(10);

        //ユーザ一覧ビューで表示
        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function show($id)
    {
        // id の値でユーザを検索して取得
        $user = User::findOrFail($id);

        // ユーザ詳細ビューで表示
        return view('users.show', [
            'user' => $user,
        ]);
    }
}
