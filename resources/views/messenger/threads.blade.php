@extends('layouts.admin-top-sidebar')

@section("title")
    Сообщения
@endsection

@section("content")
    <table class="table table-bordered">
        <tr>
            <th>Пользователь</th>
            <th>Зарегистрирован</th>
            <th>Сообщений всего</th>
            <th>Новых сообщений</th>
            <th></th>
        </tr>

        @foreach($threads as $thread)
                <?php $class = $thread->isUnread(Auth::id()) ? 'alert-success' : ''; ?>
            <tr class="{{$class}}">
                <td>
                    {{ $thread->creator()?->name ?? $thread->creator()?->login ?? 'Пользователь' }}
                </td>
                <td>
                    {{ $thread->creator()?->created_at }}
                </td>
                <td>
                    {{ count($thread->messages) }}
                </td>
                <td>
                    {{ $thread->userUnreadMessagesCount(Auth::id()) }}
                </td>
                <td>
                    <a href="{{route('message.view',['id'=>$thread->id])}}" class="btn btn-xs btn-success">
                        Открыть
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection

