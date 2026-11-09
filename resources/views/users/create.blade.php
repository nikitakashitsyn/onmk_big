@extends('layouts.admin')


@section("title")
    Блоки
@endsection

@section("content")
    <h4>Создать блок</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @include('testgroups.form')

@endsection
