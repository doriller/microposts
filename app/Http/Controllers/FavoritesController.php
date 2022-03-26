<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    /**
     * 投稿をお気に入りするaction
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        // 認証済みユーザが、idの投稿をお気に入りする
        \Auth::user()->favorite($id);
        // 前の画面へリダイレクト
        return back();
    }

    /**
     * 投稿のお気に入りを外す
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 認証済みユーザはidの投稿をお気に入りから外す
        \Auth::user()->unfavorite($id);
        // 前の画面へリダイレクト
        return back();
    }
}
