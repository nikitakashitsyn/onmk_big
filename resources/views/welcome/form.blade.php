@extends('layouts.admin-top-sidebar')

@section('title')
    Входное тестирование
@endsection



@section("content")
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{route('welcome.store_first')}}">
        @php
            $hasOldProfile = session()->hasOldInput('profile');
            $sexValue = (string) old('profile.sex', $data['sex'] ?? '');
            $ageValue = old('profile.age', $data['age'] ?? '');
            $selectedReasons = $hasOldProfile
                ? old('profile.reason', [])
                : ($data['reason'] ?? []);
            if (!is_array($selectedReasons)) {
                $selectedReasons = [];
            }
            $workoutPerWeek = (string) old('profile.workout_per_week', $data['workout_per_week'] ?? '');
            $howValue = (string) old('profile.how', $data['how'] ?? '');
            $insultValue = (string) old('profile.insult', $data['insult'] ?? '');
            $demensionValue = (string) old('profile.demension_type', $data['demension_type'] ?? '');
            $rehabValue = (string) old('profile.reabilitation', $data['reabilitation'] ?? '');
        @endphp
        <div class="card">
            <div class="card-body">
                @csrf
                <div class="form-group">
                    <label for="profile_sex">Пол</label>
                    <select class="form-control" id="profile_sex" name="profile[sex]">
                        <option value="">Укажите свой пол</option>
                        <option value="1" @if($sexValue === '1') selected @endif>Мужской</option>
                        <option value="2" @if($sexValue === '2') selected @endif>Женский</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="age">Возраст</label>
                    <input type="number" id="age" class="form-control" name="profile[age]" value="{{ $ageValue }}"
                           placeholder="Укажите свой возраст">
                </div>


                <div class="input-group">
                    <label for="target">Ваша цель участия в программе</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                           value="Восстановление после ОНМК (инсульта)"
                           name="profile[reason][]" id="reason1"
                           @if(in_array('Восстановление после ОНМК (инсульта)', $selectedReasons)) checked @endif
                    >
                    <label class="form-check-label" for="reason1">
                        Восстановление после ОНМК (инсульта)
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="profile[reason][]"
                           value="Коррекция когнитивных нарушений при деменции"
                           @if(in_array('Коррекция когнитивных нарушений при деменции', $selectedReasons)) checked
                           @endif
                           id="reason2"
                    >
                    <label class="form-check-label" for="reason2">
                        Коррекция когнитивных нарушений при деменции
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="profile[reason][]"
                           value="Профилактика (ослабления памяти, внимания, мышления или речи)"
                           @if(in_array('Профилактика (ослабления памяти, внимания, мышления или речи)', $selectedReasons)) checked
                           @endif
                           id="reason3">
                    <label class="form-check-label" for="reason3">
                        Профилактика (ослабления памяти, внимания, мышления или речи)
                    </label>
                </div>

                <div class="form-group mt-3">
                    <label for="profile_workout_per_week">У вас есть возможность заниматься 3-4 раза в неделю?</label>
                    <select class="form-control" name="profile[workout_per_week]" id="profile_workout_per_week">
                        <option value=""></option>
                        <option value="1" @if($workoutPerWeek === '1') selected @endif>Да</option>
                        <option value="0" @if($workoutPerWeek === '0') selected @endif>Нет</option>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="profile_how">Как будете заниматься?</label>
                    <select class="form-control" id="profile_how" name="profile[how]">
                        <option value=""></option>
                        <option value="Самостоятельно" @if($howValue === 'Самостоятельно') selected @endif>
                            Самостоятельно
                        </option>
                        <option value="родственником/помощником"
                                @if($howValue === 'родственником/помощником') selected @endif>С
                            родственником/помощником
                        </option>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="profile_insult">Если у Вас был инсульт, то какой</label>
                    <select class="form-control" id="profile_insult" name="profile[insult]">
                        <option value=""></option>
                        <option value="Правосторонний"
                                @if($insultValue === 'Правосторонний') selected @endif>Правосторонний
                        </option>
                        <option value="Левосторонний" @if($insultValue === 'Левосторонний') selected @endif>
                            Левосторонний
                        </option>
                        <option value="Геморрагический"
                                @if($insultValue === 'Геморрагический') selected @endif>Геморрагический
                        </option>
                        <option value="Ишемический" @if($insultValue === 'Ишемический') selected @endif>
                            Ишемический
                        </option>
                        <option value="Транзиторная ишемическая атака"
                                @if($insultValue === 'Транзиторная ишемическая атака') selected @endif>
                            Транзиторная ишемическая атака
                        </option>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="profile_demension_type">Если Вы страдаете деменцией, то какого вида:</label>
                    <select class="form-control" id="profile_demension_type" name="profile[demension_type]">
                        <option value=""></option>
                        <option value="Болезнь Альцгеймера"
                                @if($demensionValue === 'Болезнь Альцгеймера') selected @endif>Болезнь
                            Альцгеймера
                        </option>
                        <option value="сосудистая деменция"
                                @if($demensionValue === 'сосудистая деменция') selected @endif>
                            сосудистая деменция
                        </option>
                        <option value="лобно-височная деменция"
                                @if($demensionValue === 'лобно-височная деменция') selected @endif>
                            лобно-височная деменция
                        </option>
                        <option value="деменция с тельцами Леви"
                                @if($demensionValue === 'деменция с тельцами Леви') selected @endif>
                            деменция с тельцами Леви
                        </option>
                        <option value="смешанная деменция"
                                @if($demensionValue === 'смешанная деменция') selected @endif>
                            смешанная деменция
                        </option>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="profile_reabilitation">Проходили ли Вы лечение в отделениях
                        нейрореабилитации?</label>
                    <select class="form-control" id="profile_reabilitation" name="profile[reabilitation]">
                        <option value=""></option>
                        <option value="1" @if($rehabValue === '1') selected @endif>Да</option>
                        <option value="0" @if($rehabValue === '0') selected @endif>Нет</option>
                    </select>
                </div>
            </div>
        </div>

        @php
            $caregiverData = $caregiver ?? (Auth::user() ? Auth::user()->getCaregiver() : []);
        @endphp
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Данные ухаживающего лица (необязательно)</h3>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">
                    Заполните при необходимости, если пациент занимается с помощью родственника или специалиста по уходу.
                </p>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="caregiver_name">ФИО ухаживающего лица</label>
                            <input type="text"
                                   id="caregiver_name"
                                   name="caregiver[name]"
                                   maxlength="255"
                                   class="form-control @error('caregiver.name') is-invalid @enderror"
                                   value="{{ old('caregiver.name', $caregiverData['name'] ?? '') }}"
                                   placeholder="Например: Иванова Анна Сергеевна">
                            @error('caregiver.name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="caregiver_relation">Степень родства</label>
                            <input type="text"
                                   id="caregiver_relation"
                                   name="caregiver[relation]"
                                   maxlength="100"
                                   class="form-control @error('caregiver.relation') is-invalid @enderror"
                                   value="{{ old('caregiver.relation', $caregiverData['relation'] ?? '') }}"
                                   placeholder="Например: Супруг(а), Дочь, Сын, Сиделка">
                            @error('caregiver.relation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-md-0">
                            <label for="caregiver_phone">Телефон</label>
                            <input type="tel"
                                   id="caregiver_phone"
                                   name="caregiver[phone]"
                                   maxlength="50"
                                   class="form-control @error('caregiver.phone') is-invalid @enderror"
                                   value="{{ old('caregiver.phone', $caregiverData['phone'] ?? '') }}"
                                   placeholder="Например: +7 (999) 123-45-67">
                            @error('caregiver.phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label for="caregiver_email">Email</label>
                            <input type="email"
                                   id="caregiver_email"
                                   name="caregiver[email]"
                                   maxlength="255"
                                   class="form-control @error('caregiver.email') is-invalid @enderror"
                                   value="{{ old('caregiver.email', $caregiverData['email'] ?? '') }}"
                                   placeholder="Например: caregiver@example.com">
                            @error('caregiver.email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <p class="pb-3">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </p>
    </form>
@endsection
