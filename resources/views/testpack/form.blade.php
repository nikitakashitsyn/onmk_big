<?php

use App\Models\Test;
use App\Models\InitialTest;

?>

@if (isset($model))
    {{ Form::open(['url' => route('test-pack.update', $model->id), 'method' => 'PATCH']) }}
@else
    {!! Form::open(['url' => route('test-pack.store')]) !!}
@endif

<div class="form-group">
    {{ Form::label('name', 'Название') }}
    {{ Form::text('name', $model->name ?? old('name'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('description', 'Описание') }}
    {{ Form::textarea('description', $model->description ?? old('description'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('order', 'Описание') }}
    {{ Form::select('order', ['random'=>'В случайном порядке','present'=>'В указанном порядке'],null, array('class' => 'form-control')) }}
</div>

@foreach($data as $i => $c)
    <div class="card">
        <div class="card-header">
            {{$c['block']}}
        </div>
        <div class="card-body">
            @foreach($c['items'] as $j => $item)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="assign[{{$i}}]" id="q{{$i}}{{$j}}" value="{{$j+1}}" @if(isset($model->assign[$i]) && $model->assign[$i] == ($j+1))checked="checked"@endif>
                    <label class="form-check-label" for="q{{$i}}{{$j}}">
                        {{$item}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
@endforeach

<div class="form-group">
    {{ Form::label('max_attempts', 'Количество попыток') }}
    {{ Form::text('max_attempts', $model->max_attempts ?? old('max_attempts'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('timeout', 'Ограничение по времени') }}
    {{ Form::text('timeout', $model->timeout?? old('timeout'),array('class' => 'form-control')) }}
</div>

{{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}




@if(isset($model->tests))

    <h3 class="pt-5">Вопросы</h3>

    <a href="#" data-toggle="modal" data-target="#modal-default" class="btn btn-xs btn-success">
        <i class="fa fa-plus"></i> Добавить вопрос
    </a>
    <br/><br/>


    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                @foreach($model->tests as $item)
                    @if($t = $item->test)
                    <tr>
                        <td>{{$t->name}}</td>
                        <td>
                            <a href="{{route('test-pack.destroyTest',[$model->id,$item->test_id])}}"
                               class="btn btn-xs btn-warning"><span
                                    class="fa fa-trash"></span></a>
                        </td>
                    </tr>
                    @endif
                @endforeach
            </table>
        </div>
    </div>


    <div class="modal fade" id="modal-default" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Добавление вопроса</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                {!! Form::open(['url' => route('test-pack.addTest',$model->id)]) !!}
                <div class="modal-body">

                    <div class="form-group">
                        {{ Form::label('test_id', 'Вопрос') }}
                        {{ Form::select('test_id', Test::pluck('name','id'), null,['class' => 'form-control']) }}
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
