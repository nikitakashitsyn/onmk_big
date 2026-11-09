@extends('layouts.admin')


@section("title")
    Тренажеры
@endsection

@section("content")

    <p>
        <a href="{{ route('exercise.create') }}" class="btn btn-success btn-xs">Создать новый тренажер</a>
    </p>

    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tr>
                    <th>Название</th>
                    <th>Показывать на сайте</th>
                    <th>Создано</th>
                    <th></th>
                </tr>
                @foreach($items as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>
                            @if($item->visible)
                            <i class="badge badge-success">да</i>
                            @else
                                <i class="badge badge-danger">нет</i>
                            @endif
                        </td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            <a href="{{route('exercise.edit',$item->id)}}" class="btn btn-xs btn-warning">
                                <span class="fa fa-edit"></span>
                                Изменить
                            </a>

                            {!! Form::open(['url' => route('exercise.destroy',$item->id),'method'=>'delete']) !!}
                            {{ Form::button('<i class="fa fa-trash"></i>Удалить', ['type'=>'submit','class' => 'btn btn-xs btn-danger']) }}
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    {{$items->links()}}
@endsection
