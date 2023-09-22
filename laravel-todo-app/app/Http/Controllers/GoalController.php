<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    /**
     * 一覧
     * Auth::user()でログインユーザーの取得。Authファサード（窓口・正面）といってインスタンス化しなくてもメソッドを実行できるLaravelの機能。
     *->goalsをつけることでそのユーザーが持つ目標をすべて取得。userモデルのインスタンスに対してgoalsプロパティ（別テーブルの値）を取得できるのは、リレーションシップを設定しているから。
     */
    public function index() {
        $goals = Auth::user()->goals;
        $tags = Auth::user()->tags;
        // dd($goals);
        // dd('test');  
        return view('goals.index', compact('goals', 'tags'));
    }

    /**
     * 作成機能
     * バリデーションを設定しフォームに値が入力されているかチェック（required＝入力必須）
     * Goalモデルをインスタンス化して新しいレコードを作成
     * Requestクラスを使ってフォーム内容（タイトル）を取得
     * Auth::id()でログイン中のユーザーのIDを取得。
     * ログイン中のユーザーIDをuser_idカラム()に代入する
     * 一覧ページ（indexアクション）にリダイレクトさせる
     */
    public function store(Request $request) {

        $request->validate([
            'title' => 'required',
        ]);
        $goal = new Goal();
        $goal->title = $request->input('title');
        $goal->user_id = Auth::id();
        $goal->save();

        return redirect()->route('goals.index');
    }

    /**
     * 更新機能（既存データについて、フォーム内容を保存することで更新する）
     * ほぼ作成機能（storeアクション）と同じだが、以下2点異なる
     * 1.特定のデータを更新するため、49行であらかじめGoalモデルのインスタンス($goal：目標データ)を受け取る。
     * 2.既存データを更新するため、インスタンス化はいらない
     */
    public function update(Request $request, Goal $goal) {

        $request->validate([
            'title' => 'required',
        ]);
        $goal->title = $request->input('title');
        $goal->user_id = Auth::id();
        $goal->save();

        return redirect()->route('goals.index');

    }

    /**
     * 削除機能
     * 受け取ったGoalモデルのインスタンスをdelete()メソッドで削除し、一覧ページにリダイレクトさせる。
     * フォーム内容の取得等はないので、Requestクラスの型宣言はしなくていい
     */
    public function destroy(Goal $goal) {
        
        $goal->delete();

        return redirect()->route('goals.index');
    }
}
