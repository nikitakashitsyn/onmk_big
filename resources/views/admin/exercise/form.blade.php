<?php

use App\Models\Test;
use App\Models\InitialTest;

?>

@extends('layouts.admin')

@section("title")
    Тренажеры
@endsection

@section("content")

    @if (isset($model))
        {{ Form::open(['url' => route('exercise.update', $model->id), 'method' => 'PATCH']) }}
    @else
        {!! Form::open(['url' => route('exercise.store')]) !!}
    @endif

    <div class="form-group">
        {{ Form::label('name', 'Название') }}
        {{ Form::text('name', $model->name ?? old('name'), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('visible', 'показывать на сайте') }}
        {{ Form::checkbox('visible', null,$model->visible ?? old('visible')) }}
    </div>

    {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}


    @if(isset($model))
        <div class="card p-3 m-3">
            <div class="card-title">
                Назначения
            </div>
            <div class="card-body table-responsive p-1">

                <a href="#" data-toggle="modal" data-target="#modal-default" class="btn btn-xs btn-success">
                    <i class="fa fa-plus"></i> Добавить
                </a>

                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Выбранный пункт из входного тестирования</th>
                        <th>Группа тестов</th>
                        <th>Кол-во</th>
                        <th></th>
                    </tr>

                    @if($model->assignRules)
                        @foreach($model->assignRules as $assignRule)
                            <tr>
                                <td>{{$assignRule->sourceName()}}</td>
                                <td>{{$assignRule->targetName()}}</td>
                                <td>{{$assignRule['jsonData']['qty'] ?? null}}</td>
                                <td>
                                    {!! Form::open(['url' => route('exercise.destroyAssign',$assignRule->id),'method'=>'delete']) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>Удалить', ['type'=>'submit','class' => 'btn btn-xs btn-danger']) }}
                                    {{ Form::close() }}
                                </td>
                            </tr>
                        @endforeach
                    @endif

                </table>

            </div>
        </div>

        <div class="modal fade" id="modal-default" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Добавление назначения</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    {!! Form::open(['url' => route('exercise.assign',$model->id)]) !!}
                    <div class="modal-body">

                        <div class="form-group">
                            {{ Form::label('test_id', 'Ответ из входного тестирования') }}
                            {{ Form::select('jsonData[source]', \App\Models\IntroTest::getDropDown(), null,['class' => 'form-control']) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('test_id', 'Группа упражнений') }}
                            {{ Form::select('jsonData[target]', \App\Models\TestGroup::getDropDown(), null,['class' => 'form-control']) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('name', 'Кол-во тестов из группы упражнений') }}
                            {{ Form::number('jsonData[qty]', $model->name ?? old('name'), ['class' => 'form-control']) }}
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        {{ Form::submit('Далее', ['class' => 'btn btn-primary']) }}
                    </div>
                    {{ Form::close() }}
                </div>

            </div>
        </div>
    @endif

@endsection
