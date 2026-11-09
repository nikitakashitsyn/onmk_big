@extends('layouts.admin')


@section("title")
    Группы упражнений
@endsection

@section("content")

    <p>
        <a href="{{ route('test-group.create') }}" class="btn btn-success btn-xs">Создать новую группу</a>
    </p>

    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tr>
                    <th>Название</th>
                    <th>Создано</th>
                    <th>Заданий</th>
                    <th></th>
                </tr>
                @foreach($model as $item)
                    <tr>
                        <td><a href="{{route('test-group.show',$item->id)}}">{{$item->name}}</a></td>
                        <td>{{$item->created_at}}</td>
                        <td>{{count($item->tests)}}</td>
                        <td>
                            <a href="{{route('test-group.edit',$item->id)}}" class="btn btn-xs btn-warning"><span class="fa fa-edit"></span>Изменить</a>

                            {!! Form::open(['url' => route('test-group.destroy',$item->id),'method'=>'delete']) !!}
                            {{ Form::button('<i class="fa fa-trash"></i>Удалить', ['type'=>'submit','class' => 'btn btn-xs btn-danger']) }}
                            {{ Form::close() }}

                        </td>
                    </tr>
                @endforeach
            </table>

        </div>

    </div>

    {{$model->links()}}
@endsection
