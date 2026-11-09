<?php

use App\Models\Test;

?>
@extends('layouts.admin-top-sidebar')


@section("title")
    Проверка теста
@endsection

@section("content")

    @if($result)
        <div
            class="alert alert-info alert-dismissible">
            Вы набрали {{$points}}
            {{ Lang::choice('балл|балла|баллов', $points , [], 'ru')  ?? 0}}
            @if($errors)
                ({{$errors}}  {{ Lang::choice('ошибка|ошибок|ошибок', $errors , [], 'ru')  ?? 0}})
            @endif
        </div>
    @endif


    {{ Form::open() }}

    {{Form::hidden('question_id',$model->id ?? null)}}
    {{Form::hidden('exam_data_id',$examTest->id ?? null)}}

    @if($timeout = ($model->data['show_timeout']?? null))
        <div class="callout callout-danger timer-block">
            <div class="timer-text">
                Задание имеет ограничение по времени в {{$timeout}} секунд, подготовьтесь и нажмите кнопку "начать". По
                истечению времени задание скроется.
            </div>

            <button class="start-button">
                Начать тест
            </button>
        </div>
    @endif


    @if($timeout)
        <div class="d-none hidden-content" data-timeout="{{$timeout}}">
            @endif


            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Задание</h3>
                </div>

                <div class="card-body">

                    @php
                        $tts =  $model->updateQuestionTts();
                    @endphp

                    @if($path = $model->getQuestionAudioUrl())
                        <a href="#" class="btn btn-default" id="playQuestion" data-path="{{$path}}">
                            <i class="fa fa-music"></i>
                        </a>
                    @endif

                    <div class="row">


                        @if(isset($model->data['question']['type']) && in_array($model->data['question']['type'],['text','text_with_image','video_with_text','audio_with_text']))
                            <div>
                                {{$model->data['question']['text'] ?? null}}
                            </div>
                        @endif

                        @if(isset($model->data['question']['type']) && in_array($model->data['question']['type'],['image','text_with_image']))
                            @if(isset($model->data['question']['image']))
                                <div class="col-md-12">
                                    <img src="{{$model->data['question']['image']}}" alt="" class="img-thumbnail"
                                         style="max-width: 30%">
                                </div>
                            @endif
                        @endif

                        @if(isset($model->data['question']['type']) && in_array($model->data['question']['type'], ['video_with_text','audio_with_text']))
                            @include('test.audio_video')
                        @endif

                        @if($model->type === Test::TYPE_TABLES_SCHULTE)
                            @include('test.schulte')
                        @endif

                    </div>

                </div>
            </div>
            @if($timeout)
        </div>
    @endif

    @if($timeout)
        <div class="d-none hidden-answers" data-timeout="{{$timeout}}">
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        @if($model->type === Test::TYPE_INPUT)
                            Впишите ответ
                        @else
                            Выберите ответ
                        @endif
                    </h3>
                </div>

                <div class="card-body">

                    <div class="form-group">
                        @if($model->type === Test::TYPE_CHOICE)
                            <div class="row">
                                @if(isset($answers))
                                    @foreach($answers as $i=>$answer)
                                        @if(isset($answer['image']))
                                            <div class="col-sm-4 py-4">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <p class="card-text">
                                                            <img src="{{$answer['image']}}" alt=""
                                                                 class="img-thumbnail">
                                                            @if(isset($model->data['question']['multiple']) && $model->data['question']['multiple'] == "1")
                                                                <input type="checkbox" id="customRadio{{$i}}"
                                                                       value="{{$answer['text'] ?? $answer['image']}}"
                                                                       style="position: absolute;bottom:20px;left:20px"
                                                                       name="answer[]">
                                                            @else
                                                                <input type="radio" id="customRadio{{$i}}"
                                                                       value="{{$answer['text'] ?? $answer['image']}}"
                                                                       style="position: absolute;bottom:20px;left:20px"
                                                                       name="answer">
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-sm-12 py-4">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <p class="card-text">
                                                            @if(isset($model->data['question']['multiple']) && $model->data['question']['multiple'] == "1")
                                                                <input class="custom-control-input" type="checkbox"
                                                                       id="customRadio{{$i}}"
                                                                       value="{{$answer['text']}}"
                                                                       style=""
                                                                       name="answer[]">
                                                            @else
                                                                <input class="custom-control-input" type="radio"
                                                                       id="customRadio{{$i}}"
                                                                       value="{{$answer['text']}}"
                                                                       style=""
                                                                       name="answer">
                                                            @endif
                                                            <label for="customRadio{{$i}}"
                                                                   class="custom-control-label ml-3">{{$answer['text']}}</label>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        @endif


                        @if($model->type === Test::TYPE_INPUT)
                            <input class="form-control" type="text" name="answer">
                        @endif


                    </div>
                </div>
            </div>
            @if($timeout)
        </div>
    @endif
    {{ Form::submit('Дальше', array('class' => 'btn btn-success')) }}






    {{ Form::close() }}

    @role('ROLE_ADMIN')
    <p class="pt-3">
        <a href="{{ route('test.edit',$model->id) }}" target="_blank"
           class="btn btn-sm btn-danger">Редактировать</a>
    </p>
    @endrole

@endsection

@push('javascript')
    $("#playQuestion").click(function() {
    var audio = new Audio($(this).data('path'));
    audio.play();
    });

    $(".start-button").click(function(event) {
    event.preventDefault();
    $(".hidden-content").removeClass('d-none');
    //

    $(".timer-block").slideUp();


    timeout = $(".hidden-content").data('timeout') * 1000;

    setTimeout(() => {
    console.log("hide");
    $(".hidden-content").addClass('d-none');
    $(".hidden-answers").removeClass('d-none');
    }, timeout)
    });
@endpush
