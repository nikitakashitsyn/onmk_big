@extends('layouts.admin-top-sidebar')

@section("content")


    @if (Auth::guest())
        Добро пожаловать, для прохождения тестирования вам необходимо авторизоваться или зарегистрироваться :<br/>
    @else

        @if(count($exams)>0)

            @foreach($exams as $exam)
                <div class="callout callout-danger">
                    У вас имеется активный тест<br/>
                </div>
                <a href="{{route('runExam',$exam->id)}}" class="btn btn-success">Продолжить прохождение теста</a>
                @endforeach
                </br>
                @else

                    @if(1==2)
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Выберите тест из представленных ниже:
                                </h3>
                            </div>
                            <!-- /.card-header -->

                            <div class="table-responsive">
                                <div class="card-body">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>Название</th>
                                            <th>Описание</th>
                                            <th>Заданий</th>
                                            <th>Попытки</th>
                                            <th></th>
                                        </tr>
                                        @foreach($testpacks as $testpack)
                                            <tr>
                                                <td>{{$testpack->pack->name}}</td>
                                                <td> {{$testpack->pack->description}}</td>
                                                <td>
                                                    <div class="badge badge-info">
                                                        {{count($testpack->pack->tests)}} {{ Lang::choice('вопрос|вопроса|вопросов', $testpack->pack->tests, [], 'ru')  }}
                                                    </div>
                                                </td>
                                                <td>
                                                    @foreach($testpack->pack->attempts as $attempt)
                                                        {{$attempt->created_at}}
                                                        <div class="badge badge-success">
                                                            {{$attempt->result}} {{ Lang::choice('балл|балла|баллов', $attempt->result , [], 'ru')  }}
                                                        </div><br/>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <a href="{{route('test-pack.run',$testpack->pack->id)}}"
                                                       class="btn btn-xs btn-success">Запустить
                                                        тест</a><br/>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    @endif


                    @foreach($exercises as $exercise)

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">
                                    {{$exercise->name}}
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Дата</th>
                                            <th>Баллы</th>
                                            <th>Ошибок</th>
                                            <th>Пройдено за</th>
                                        </tr>

                                        @foreach($exercise->attempts as $attempt)
                                            @if($attempt->user_id === Auth::id())

                                                <tr>
                                                    <td>{{$attempt->created_at}}</td>
                                                    <td>

                                                        {{$attempt->result}} {{ Lang::choice('балл|балла|баллов', $attempt->result , [], 'ru')  }}
                                                        из {{$attempt->total}}
                                                        @if($attempt->total > 0 && $attempt->result > 0 )
                                                            ({{ round($attempt->result/$attempt->total * 100,2) }}
                                                            %)
                                                        @else
                                                            (0%)
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $attempt->penaltyPoints ?? 0 }}
                                                    </td>
                                                    <td>
                                                        @if($elapsed = $attempt->getElapsedTimeAttribute())
                                                            {{Carbon\CarbonInterval::seconds($elapsed)->cascade()->forHumans()}}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif

                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('exercise.run',$exercise->id)}}"
                                   class="btn btn-success">
                                    Запустить тренажер
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
                @endif
                @endsection
