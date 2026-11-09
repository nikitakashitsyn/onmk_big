<form method="post" action="{{route('message.store',['thread'=>$thread->id])}}">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <textarea class="form-control" id="message" name="message" rows="3"
                          placeholder="Для отправки сообщения наберите текст и нажмите отправить"></textarea>
            </div>
            <input type="submit" class="btn btn-default" value="Отправить">
        </div>
    </div>
</form>
