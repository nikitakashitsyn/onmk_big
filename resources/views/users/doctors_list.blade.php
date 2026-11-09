@extends('layouts.admin-top-sidebar')


@section("title")
    Доктора
@endsection

@section("content")

    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif


    <div class="card">
        <div class="card-body table-responsive p-3">
            Ниже указаны доктора которые были назначены вам , если список пуст , попросите нужного доктора добавить вас
            по идентификатору <b>{{ Auth::user()->login  }}</b>
        </div>
    </div>


    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tr>
                    <th>Email</th>
                    <th>ФИО</th>
                    <th>Зарегистрирован</th>
                    <th></th>
                </tr>
                @foreach($doctors as $item)
                    <tr>
                        <td><a href="{{route('users.show',$item->id)}}">{{$item->email}}</a></td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            <a href="{{route('message.send',['id'=> $item->id])}}" class="btn btn-xs btn-warning">
                                <span class="fa fa-envelope"></span>Отправить сообщение
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection
