@extends('layouts.admin-top-sidebar')

@section("title")
    Добавление нового пациента
@endsection

@section("content")
    <div class="card">
        <div class="card-body table-responsive p-3">
            Для добавления пациента введите его 6-значный логин или email
        </div>
    </div>


    <form method="post">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="ident" class="form-label">Логин или email пациента</label>
                    <input type="text" class="form-control" id="ident" name="ident"
                           placeholder="6-значный логин или email"
                           value="{{ old('ident') }}"
                           required="required">
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" id="comment" name="comment"
                           placeholder="Комментарий"
                           value="{{ old('comment') }}"
                           required="required">
                </div>
                <input type="submit" class="btn btn-default" value="Добавить">
            </div>
        </div>
    </form>

@endsection

