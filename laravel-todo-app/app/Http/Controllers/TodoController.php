<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{  
    /**
     * 作成機能（storeアクション）
     * バリデーションは何より先（フォーム内容取得前に判断するから）
     *【流れ】インスタンス化してレコードを作る⇒フォーム内容を取得して本文に代入⇒
     *ログイン中のuser_idはAuth::で取得⇒goal_idは渡されたGoalモデルのインスタンスからIDを取得して代入⇒
     *doneカラムに初期値のfalseを代入（作成した当初は未完了のため）⇒保存⇒リダイレクト
     */
    public function store(Request $request, Goal $goal)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $todo = new Todo();
        $todo->content = $request->input('content');
        $todo->description = $request->input('description'); //詳細フォームの追加
        $todo->user_id = Auth::id();
        $todo->goal_id = $goal->id;
        $todo->done = false;

        $todo->save();

        // チェックされたタグidを配列で取得し、sync()メソッドで中間テーブルに保存する
        $todo->tags()->sync($request->input('tag_ids'));

        return redirect()->route('goals.index');
    }

    /**
     * 更新機能（updateアクション）
     * １:ドロップダウンの編集リンクをクリックし、既存のTodoを更新する（contentカラムの値の更新）
     * ２:ドロップダインの「完了」「未完了」をクリックして切り替える（doneカラムの値の更新）
     * input()は第2引数を渡すことで、第1引数に指定したフォームの値が存在しない場合の初期値にすることができる（詳細フォームの入力値の更新がなければ、todoテーブルのdescriptionカラムの値になるつまり、元々の入力内容が残る）：53行目
    */
    public function update(Request $request, Goal $goal, Todo $todo) {
        $request->validate([
            'content' => 'required',
        ]);

        $todo->content = $request->input('content');
        $todo->description = $request->input('description', $todo->description); //詳細フォームの取得
        $todo->user_id = Auth::id();
        $todo->goal_id = $goal->id;
        $todo->done = $request->boolean('done', $todo->done);
        $todo->save();

        //通常の編集のとき（＝完了と未完了の切り替えでないとき）にのみタグを変更（更新）する
        //has()メソッド：（）の値がフォームから送信されたかどうかをチェック。送信されていればtrue
        // ! は否定の意。今回は「'done'というname属性を持つinputタグの値がフォームから送信されなかったとき」になる。
        //doneにすると編集できない仕様のため、編集画面でdoneというnameを持つ値は存在しない。だからif文が成り立ち中間テーブルが更新される。
        if (!$request->has('done')) {
            $todo->tags()->sync($request->input('tag_ids'));
        }

        return redirect()->route('goals.index');
    }

    /**
     * 削除機能（destroyアクション）
     * $goalを使わんので本当はいらないが、ルーティングを一括設定するとURLの{goal}が自動付与されてるのでGoalモデルのインスタンスを受け取らんといけん（自分で個別に設定してればルートのURLは{goal}なしで作れる）
     * 今回は一括設定なのでGoal必要になる。URLと同じ順にインスタンスを渡す
     */
    public function destroy(Goal $goal, Todo $todo) {
        $todo->delete();

        return redirect()->route('goals.index');
    }
}
