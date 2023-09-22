
{{-- indexビューのforeachの中で、includeで呼び出す --}}
{{-- foreachで取り出すなかで、idの値が重複せずモーダルやリンクが連携できるように、末尾に{{ $goal->id }}をつけている --}}
<div class="modal fade" id="editGoalModal{{ $goal->id }}" tabindex="1" aria-labelledby="editGoalModalLabel{{ $goal->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGoalModalLabel{{ $goal->id }}">目標の編集</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            {{-- action属性にrouteヘルパーを使い、第2引数でGoalモデルのインスタンスを渡すことで、特定データのupdateアクションで編集できるようにする --}}
            <form action="{{ route('goals.update', $goal )}}" method="post">
                @csrf
                @method('patch')
                <div class="modal-body">
                    {{-- valueに初期の値をいれておくことで、既存データが設定される（フォーム内に表示される） --}}
                    <input type="text" class="form-control" name="title" value="{{ $goal->title }}">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">更新</button>
                </div>
            </form> 
        </div>
    </div>
</div>
