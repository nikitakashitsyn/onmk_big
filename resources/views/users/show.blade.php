<?php use Carbon\CarbonInterval; ?>

@extends(auth()->check() && auth()->user()->hasRole('ROLE_ADMIN') && request()->is('admin/*') ? 'layouts.admin' : 'layouts.admin-top-sidebar')

@section('title')
    Карточка пациента: {{ $user->name ?? $user->login }}
@endsection

@section('content')

    <div class="mb-3">
        @if(auth()->check() && auth()->user()->hasRole('ROLE_ADMIN') && request()->is('admin/*'))
            <a href="{{ route('users.index') }}" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Назад к списку пользователей
            </a>
        @else
            <a href="{{ route('patients_list') }}" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Назад к списку пациентов
            </a>
        @endif
    </div>

    <div class="row">

        {{-- Основная информация --}}
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <h3 class="profile-username text-center">
                        {{ $user->name ?? 'Без имени' }}
                    </h3>
                    <p class="text-muted text-center">
                        @foreach($user->roles ?? [] as $role)
                            <span class="badge badge-info">{{ $role }}</span>
                        @endforeach
                    </p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Логин</b>
                            <span class="float-right">{{ $user->login ?? '—' }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Email</b>
                            <span class="float-right">{{ $user->email ?? '—' }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Зарегистрирован</b>
                            <span class="float-right">{{ $user->created_at?->format('d.m.Y') ?? '—' }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Пол</b>
                            <span class="float-right">
                                @php $sex = $user->jsonData['initial_data']['sex'] ?? null; @endphp
                                {{ $sex == 1 ? 'Мужской' : ($sex == 2 ? 'Женский' : '—') }}
                            </span>
                        </li>
                        <li class="list-group-item">
                            <b>Возраст</b>
                            <span class="float-right">{{ $user->jsonData['initial_data']['age'] ?? '—' }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Тип инсульта</b>
                            <span class="float-right">{{ $user->jsonData['initial_data']['insult'] ?? '—' }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Цель</b>
                            <span class="float-right">
                                {{ implode(', ', $user->jsonData['initial_data']['reason'] ?? []) ?: '—' }}
                            </span>
                        </li>
                    </ul>

                    @if(!empty($user->id))
                        <a href="{{ route('message.send', ['id' => $user->id]) }}" class="btn btn-warning btn-block">
                            <i class="fa fa-envelope"></i> Написать сообщение
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Когнитивные сферы + история экзаменов --}}
        <div class="col-md-8">

            {{-- Результаты самооценки --}}
            @if(!empty($user->jsonData['results']))
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Самооценка когнитивных сфер</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Сфера</th>
                                    <th>Балл (1–6)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $spheres = ['Восприятие','Внимание','Память','Мышление','Речь','Движения'];
                                @endphp
                                @foreach($spheres as $idx => $sphere)
                                    @php $val = $user->jsonData['results'][$idx] ?? null; @endphp
                                    <tr>
                                        <td>{{ $sphere }}</td>
                                        <td>
                                            @if($val !== null)
                                                <span class="badge badge-{{ $val <= 2 ? 'success' : ($val <= 4 ? 'warning' : 'danger') }}">
                                                    {{ $val }}
                                                </span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- История прохождений --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">История тестирований</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Тест / Тренажёр</th>
                                <th>Дата</th>
                                <th>Статус</th>
                                <th>Результат</th>
                                <th>Время</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->exams->sortByDesc('created_at') as $exam)
                                <tr>
                                    <td>{{ $exam->pack?->name ?? 'Тренажёр / Без пакета' }}</td>
                                    <td>{{ $exam->created_at?->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $exam->status === 'ended' ? 'success' : 'secondary' }}">
                                            {{ $exam->status === 'ended' ? 'Завершён' : 'В процессе' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($exam->status === 'ended')
                                            <span class="badge badge-success">{{ $exam->result }} б.</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>
                                        @if($elapsed = $exam->getElapsedTimeAttribute())
                                            {{ CarbonInterval::seconds($elapsed)->cascade()->forHumans() }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Тестирований не найдено</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

@endsection
