{{-- ToDoの作成用モーダル --}}

<div class="modal fade" id="addTodoModal{{ $goal->id }}" tabindex="-1" aria-labelledby="addTodoModalLabel{{ $goal->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTodoModalLabel{{ $goal->id }}">ToDoの追加</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <form action="{{ route('goals.todos.store', $goal)}}" method="post">
                @csrf
                <div class="modal-body">
                    <p><h6>ToDo</h6></p>
                    <input type="text" class="form-control" name="content">
                    <p><h6>詳細</h6></p>
                    <input type="text" class="form-control" name="description">
                    <div class="d-flex flex-wrap">
                        {{-- 登録されているタグを配列で繰り返し取り出し、タグの数だけチェックボックスを表示。
                        チェックボックスは複数選択可。name属性でidを配列にするとvalueの値を複数渡すことができるため、
                        チェックされたすべてのタグのIDをアクション内で取得できるようになる --}}
                        @foreach ($tags as $tag)
                            <label>
                                <div class="d-flex align-items-center mt-3 me-3">
                                    <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}">
                                    <span class="badge bg-secondary ms-1">{{ $tag->name }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">登録</button>
                </div>
            </form>
        </div>
    </div>
</div>