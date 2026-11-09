<?php

use App\Models\Test;

?>

@extends('layouts.admin')


@section("title")
    Группа упражнений <b>{{$model->name}}</b>
@endsection

@section("content")

    <a href="#" data-toggle="modal" data-target="#modal-default" class="btn btn-xs btn-success">
        <i class="fa fa-plus"></i> Добавить упражнение
    </a>
    <br/><br/>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Упражнения</h3>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tr>
                    <th>Название</th>
                    <th>Тип</th>
                    <th>Создано</th>
                    <th>&nbsp;</th>
                </tr>
                @foreach($model->tests as $test)
                    <tr>
                        <td>{{$test->name}}</td>
                        <td>{{$test->type()}}</td>
                        <td>{{$test->created_by}}</td>
                        <td>12</td>
                        <td>
                            {!! Form::open(['url' => route('test.destroy',$test->id),'method'=>'delete']) !!}
                            <a href="{{route('runTest',$test->id)}}" class="btn btn-xs btn-primary"
                               target="_blank">
                                <span class="fa fa-edit"></span>Запустить
                            </a>

                            <a href="{{route('test.edit',$test->id)}}" class="btn btn-xs btn-warning">
                                <span class="fa fa-edit"></span>Изменить
                            </a>

                            {{ Form::button('<i class="fa fa-trash"></i>Удалить', ['type'=>'submit','class' => 'btn btn-xs btn-danger']) }}
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>


    <div class="modal fade" id="modal-default" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Создание теста</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                {!! Form::open(['url' => route('createTest',$model->id)]) !!}
                <div class="modal-body">

                    <div class="form-group">
                        {{ Form::label('name', 'Name') }}
                        {{ Form::text('name', null, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('type', 'Type') }}
                        {{ Form::select('type', Test::TYPES, null,['class' => 'form-control']) }}
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    {{ Form::submit('Далее', ['class' => 'btn btn-primary']) }}
                </div>
                {{ Form::close() }}
            </div>

        </div>
    </div>


@endsection
