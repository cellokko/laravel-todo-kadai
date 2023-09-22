<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    /**
     * 作成機能storeアクション（createは作成ページ。Goalコントローラでページ作成済のため不要）
     * タグは１ユーザにのみ属するが、多数の目標に属する。
     * 先ずバリデーション（入力必須チェック）⇒インスタンス化してレコード作成⇒フォーム内容（タグの名前）をカラムに代入⇒ログイン中のユーザー代入⇒tagテーブルに保存⇒一覧ページにリダイレクト
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
        ]);

        $tag = new Tag();
        $tag->name = $request->input('name');
        $tag->user_id = Auth::id();
        $tag->save();

        return redirect()->route('goals.index');
    }

    /**
     * 更新機能updateアクション（editは更新ページ。今回はGoalコントローラで作成済）
     * 特定のタグを更新するため、Tagモデルからインスタンスを受け取る
     * バリデ⇒タグの名前を代入⇒ログイン中のユーザーIDを代入⇒テーブルに保存（＝更新）⇒一覧ページにリダイレクト
     */
    public function update(Request $request, Tag $tag) {
        $request->validate([
            'name' => 'required',
        ]);

        $tag->name = $request->input('name');
        $tag->user_id = Auth::id();
        $tag->save();

        return redirect()->route('goals.index');
    }

    /**
     * 削除機能destroyアクション
     */
    public function destroy(Tag $tag) {
        $tag->delete();

        return redirect()->route('goals.index');
    }
}
