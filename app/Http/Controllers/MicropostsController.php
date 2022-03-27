<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MicropostsController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザの取得
            $user = \Auth::user();
            // ユーザとフォロー中ユーザの投稿の一覧を作成日時の降順で取得
            $microposts = $user->feed_microposts()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user'       => $user,
                'microposts' => $microposts,
            ];
        }

        // Wlcomeビューで表示
        return view('welcome', $data);
    }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:255',
        ]);

        // 認証済みユーザ(閲覧者)の投稿として作成(リクエストされた値をもとに作成)
        $request->user()->microposts()->create([
            'content' => $request->content,
        ]);

        // 前のURLへリダイレクトさせる
        return back();
    }

    public function destroy($id)
    {
        // idの値で投稿を検索して取得
        $micropost = \App\Micropost::findOrFail($id);

        // 認証済みユーザ(閲覧者)がその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $micropost->user_id) {
            $micropost->delete();
        }

        // 前のURLへリダイレクト
        return back();
    }

    public function favoriteList()
    {
        $data = [];
        if (\Auth::check()) {
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザのお気に入り投稿を取得
            //$microposts = $user->favorite_microposts()->orderBy('created_at', 'desc')->paginate(10);
            $ins = new \App\Micropost;
            $microposts = $ins
                            ->join('favorites', 'microposts.id', '=', 'favorites.micropost_id')
                            ->select('microposts.*')
                            ->where('favorites.user_id', $user->id)
                            //->get()
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
            //dd($user->id);
            $data = [
                'user'       => $user,
                'microposts' => $microposts,
            ];

            // favorite_listビューで表示
            return view('users.favorite_list', $data);
        }
    }
}
