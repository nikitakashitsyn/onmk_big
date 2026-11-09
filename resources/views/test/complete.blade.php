@extends('layouts.admin-top-sidebar')


@section("title")
Тест пройден.
@endsection

@section("content")

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Поздравляем</h3>
    </div>

    <div class="card-body">
        <div class="callout callout-success">Вы прошли тест!</div>
    </div>
</div>

@endsection
