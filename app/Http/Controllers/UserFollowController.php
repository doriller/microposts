<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
{
    /**
     * ユーザをフォローするaction
     * 
     * @param  $id 相手ユーザのid
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        // 認証済みユーザ(閲覧者)が、idのユーザをフォローする
        \Auth::user()->follow($id);
        // 前のURLへリダイレクト
        return back();
    }

    /**
     * ユーザをアンフォローするaction
     * 
     * @param  $id 相手ユーザid
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 認証済みユーザ(閲覧者)が、idのユーザをアンフォローする
        \Auth::user()->unfollow($id);
        // 前のURLへリダイレクト
        return back();
    }
}
