<?php

use Carbon\Carbon;
use Carbon\CarbonInterval;

?>

@extends('layouts.admin')


@section("title")
    Результаты тестирований
@endsection

@section("content")

    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif



    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tr>
                    <th>Тест</th>
                    <th>Пользователь</th>
                    <th>Дата</th>
                    <th>Результат</th>
                    <th>Время</th>
                </tr>
                @foreach($exams as $exam)
                    <tr>
                        <td>{{ $exam->pack?->name ?? 'Без пакета / Тест' }}</td>
                        <td>{{ $exam->user?->email ?? $exam->user?->login ?? 'Удалённый пользователь' }}</td>
                        <td>{{$exam->created_at}}</td>
                        <td>
                            <div class="badge badge-success">
                                {{$exam->result}}
                            </div>
                        </td>
                        <td>
                            @if($time = $exam->elapsed_time)
                                {{CarbonInterval::seconds($time)->forHumans()}}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $exams->links() }}
    </div>
@endsection
