<?php

use App\Models\Test
?>
@push('javascript')
    $('.remove-card').click(function() {
    var closeset = $(this).closest('.card');
    closeset.remove();
    })

    $('.upload-btn').click(function() {
    var file = $(this).closest('.upload-file').find('.file-element');
    file.click();
    });
@endpush

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
                    @endif

                    <div class="upload-file text-center pt-1">
                        {{ Form::file('data[question][image]', ['class' => 'd-none form-control file-element']) }}
                        <a href="#" class="btn btn-xs btn-success upload-btn">
                            <i class="fa fa-camera"></i> Добавить
                        </a>
                    </div>

                </div>
            </div>
            <div class="col-md-10">
                <div class="form-group">
                    {{ Form::label('name', 'Текст задания') }}
                    {{ Form::textarea('data[question][text]', $model->data['question']['text'], ['rows'=>3,'class' => 'form-control']) }}
                </div>
            </div>

            {{ Form::label('name', 'Тип') }}
            {{ Form::select('data[question][type]',['text'=>'Текст','text_with_image'=>'Текст + изображение','video_with_text'=>'Текст + видео','audio_with_text'=>'Текст + аудио'] ,$model->data['question']['type'] ?? null, ['class' => 'form-control']) }}

        </div>
    </div>
</div>

@if(in_array($model->type,[Test::TYPE_CHOICE , Test::TYPE_INPUT]))

    @foreach($data as $i=>$row)
        @include('test.simple_question')
    @endforeach

@endif

{{ Form::submit('Save', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}


