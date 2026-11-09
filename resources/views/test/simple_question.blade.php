<?php

use App\Models\Test
?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Вариант ответа {{$i}}</h3>

        <div class="card-tools">
            <button type="button" wire:click.prevent="removeAnswer({{$i}})" class="btn btn-tool">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <div class="card-body">

        <div class="row">

            @if($model->type === Test::TYPE_CHOICE)
                <div class="col-md-2">
                    <div class="form-group">

                        @if(isset($model->data['answers'][$i]['image']))
                            <img src="{{$model->data['answers'][$i]['image']}}" alt="" class="img-thumbnail">
                            <input type="hidden" name="data[answers][{{$i}}][image]" value="{{$model->data['answers'][$i]['image']}}">
                        @endif

                        <div class="upload-file text-center pt-1">
                            {{ Form::file('files[answers]['.$i.'][uploadfile]', ['class' => 'form-control file-element']) }}
                            <a href="#" class="btn btn-xs btn-success upload-btn">
                                <i class="fa fa-camera"></i> Добавить
                            </a>
                        </div>

                    </div>
                </div>
            @endif
            <div class="col-md-10">
                <div class="form-group">
                    {{ Form::label('name', 'Ответ') }}
                    @if($model->type === Test::TYPE_CHOICE)
                        <textarea wire:model="answers.{{$i}}.text" name="data[answers][{{$i}}][text]" id="" cols="30"
                                  rows="3"
                                  class="form-control">{{$model->data['answers'][$i]['text']?? null}}</textarea>
                    @endif
                    @if($model->type === Test::TYPE_INPUT)
                        {{ Form::text('data[answers]['.$i.'][text]', $model->data['answers'][$i]['text']?? null, ['class' => 'form-control','rows'=>2]) }}
                    @endif
                </div>

                <div class="form-group">
                    {{ Form::label('mark', 'Баллов') }}
                    <input type="text" wire:model="answers.{{$i}}.mark" name="data[answers][{{$i}}][mark]"
                           value="{{$model->data['answers'][$i]['mark']?? null}}" class="form-control">
                </div>

            </div>

        </div>


    </div>
</div>
