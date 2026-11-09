@extends('layouts.admin')


@section("title")
    Пользователи
@endsection

@section("content")


    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif


    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tr>
                    <th>Email</th>
                    <th>Роль</th>
                    <th>Создано</th>
                    <th></th>
                </tr>
                @foreach($model as $item)
                    <tr>
                        <td><a href="{{route('users.show',$item->id)}}">{{$item->email}}</a></td>
                        <td>Администратор</td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            <a href="{{route('users.edit',$item->id)}}" class="btn btn-xs btn-warning"><span class="fa fa-edit"></span>Изменить</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    {{$model->links()}}
@endsection
