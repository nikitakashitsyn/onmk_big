@if(isset($model))
    {{ Form::open(['url' => route('test-group.update', $model->id), 'method' => 'PATCH']) }}
@else
    {!! Form::open(['url' => route('test-group.store')]) !!}
@endif



<div class="form-group">
    {{ Form::label('name', 'Название') }}
    {{ Form::text('name', $model->name ?? old('name'), array('class' => 'form-control')) }}
</div>

{{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

