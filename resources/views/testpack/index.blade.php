@extends('layouts.admin')


@section("title")
    Тренажеры
@endsection

@section("content")

    <p>
        <a href="{{ route('test-pack.create') }}" class="btn btn-success btn-xs">Создать новый тренажер</a>
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
                    <th>Назначено</th>
                    <th>Заданий</th>
                    <th></th>
                </tr>
                @foreach($packs as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            @if($item->assign)
                                @foreach($item->assign as $key=>$assign)
                                    <div class="badge badge-info">
                                        {{\App\Models\IntroTest::getText($key,$assign)}}
                                    </div>
                                    <br/>
                                @endforeach
                            @endif
                        </td>
                        <td>{{count($item->tests)}}</td>
                        <td>
                            <a href="{{route('test-pack.edit',$item->id)}}" class="btn btn-xs btn-warning">
                                <span class="fa fa-edit"></span>
                                Изменить
                            </a>

                            {!! Form::open(['url' => route('test-pack.destroy',$item->id),'method'=>'delete']) !!}
                            {{ Form::button('<i class="fa fa-trash"></i>Удалить', ['type'=>'submit','class' => 'btn btn-xs btn-danger']) }}
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    {{$packs->links()}}
@endsection
