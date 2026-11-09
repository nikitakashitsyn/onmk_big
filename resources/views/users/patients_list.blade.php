@extends('layouts.admin-top-sidebar')


@section("title")
    Мои пациенты
@endsection

@section("content")

    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-3">
            Ниже указаны Ваши пациенты, для добавления нового пациента нажмите
            <a href="{{route('patients.add')}}" class="btn btn-success btn-xs">+ Добавить</a>
        </div>
    </div>


    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tr>
                    <th>Идентификатор</th>
                    <th>Комментарий</th>
                    <th>Добавлен</th>
                    <th></th>
                </tr>
                @foreach($patients as $item)
                    <tr>
                        <td>
                            <a href="{{ route('patients.show', $item->user->id) }}">{{ $item->user->login }}</a>
                        </td>
                        <td>
                            {{$item->comment ?? '#'}}
                        </td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            <a href="{{route('message.send',['id'=> $item->user->id])}}" class="btn btn-xs btn-warning">
                                <span class="fa fa-envelope"></span>Отправить сообщение
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection
