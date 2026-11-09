<?php

use App\Models\Test
?>


{{ Form::open(['url' => route('test.update', $model->id), 'method' => 'PATCH','enctype' => 'multipart/form-data']) }}

<div class="card">
    <div class="card-body">
        <div class="form-group">
            {{ Form::label('name', 'Название теста') }}
            {{ Form::text('name', $model->name ?? old('name'), array('class' => 'form-control')) }}
        </div>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <h3 class="card-title">Задание</h3>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">

                    @if(isset($model->data['question']['image']))
                        <img class="img-thumbnail" src="{{$model->data['question']['image']}}" alt="">
                        <input type="hidden" name="data[question][image]" value="{{$model->data['question']['image']}}">
                    @endif

                    <div class="upload-file text-center pt-1">
                        {{ Form::file('data[question][uploadfile]', ['class' => 'form-control file-element']) }}
                        <a href="#" class="btn btn-xs btn-success upload-btn">
                            <i class="fa fa-camera"></i> Добавить
                        </a>
                    </div>

                </div>
            </div>
            <div class="col-md-10">
                <div class="form-group">
                    {{ Form::label('name', 'Текст задания') }}
                    {{ Form::textarea('data[question][text]', $model->data['question']['text'] ?? null, ['rows'=>3,'class' => 'form-control']) }}
                </div>
            </div>

            {{ Form::label('name', 'Тип') }}
            {{ Form::select('data[question][type]',['text'=>'Текст','text_with_image'=>'Текст + изображение','video_with_text'=>'Текст + видео','audio_with_text'=>'Текст + аудио'] ,$model->data['question']['type'] ?? null, ['class' => 'form-control']) }}

            {{ Form::label('name', 'Несколько ответов') }}
            {{ Form::select('data[question][multiple]',[false=>'Нет',true=>'Да',] ,$model->data['question']['multiple'] ?? false, ['class' => 'form-control']) }}

            {{ Form::label('name', 'Формат') }}
            {{ Form::select('type',Test::TYPES ,$model->type ?? null, ['class' => 'form-control']) }}

            {{ Form::label('name', 'Скрывать задание через (cек)') }}
            {{ Form::text('data[show_timeout]', $model->data['show_timeout'] ?? old('data[show_timeout]'), array('class' => 'form-control')) }}
        </div>
    </div>
</div>




@if(in_array($model->type,[Test::TYPE_CHOICE , Test::TYPE_INPUT]))

    @foreach($answers as $i=>$answer)
        @include('test.simple_question')
    @endforeach

    <div align="center">
        <a href="#" wire:click.prevent="addAnswer" class="btn btn-success align-content-center">Добавить вариант
            ответа</a>
    </div>

@endif

{{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

{{ Form::open(['url' => route('test.destroy', $model->id), 'method' => 'DELETE']) }}
{{ Form::submit('Удалить тест', array('class' => 'btn btn-danger mt-2' , 'onclick'=>"return confirm('Подтвердите удаление')" )) }}
{{ Form::close() }}
