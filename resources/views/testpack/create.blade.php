@extends('layouts.admin')


@section("title")
    Тесты
@endsection

@section("content")
    <h4>Создать новый тест</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @include('testpack.form')

@endsection
