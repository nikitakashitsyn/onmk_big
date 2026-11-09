@extends('layouts.admin-top-sidebar')

@section("title")
    Добавление нового пациента
@endsection

@section("content")
    <div class="card">
        <div class="card-body table-responsive p-3">
            Для добавления клиента вам необходимо знать его идентификатор (6 цифр)
        </div>
    </div>


    <form method="post">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <input class="form-control" id="ident" name="ident" placeholder="Идентификатор пользователя"
                           required="required"></input>
                </div>

                <div class="mb-3">
                    <input class="form-control" id="comment" name="comment" placeholder="Комментарий"
                           required="required"></input>
                </div>
                <input type="submit" class="btn btn-default" value="Добавить">
            </div>
        </div>
    </form>

@endsection

