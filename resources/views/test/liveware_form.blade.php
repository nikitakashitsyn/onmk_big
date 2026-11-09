@extends('layouts.admin')

@section("title")
    Редактирование теста
@endsection

@section("content")
    <div>
        @livewire('simple-test',['model'=>$model])
    </div>
@endsection
