@extends('layouts.admin-top-sidebar')

@section('title')
    Входное тестирование
@endsection



@section("content")
    <form method="post" action="{{route('welcome.store_first')}}">
        <div class="card">
            <div class="card-body">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Пол</label>
                    <select class="form-control" name="profile[sex]">
                        <option>Укажите свой пол</option>
                        <option value="1" @if(($data['sex'] ?? 0) == 1) selected @endif>Мужской</option>
                        <option value="2" @if(($data['sex'] ?? 0) == 2) selected @endif>Женский</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="age">Возраст</label>
                    <input type="number" class="form-control" name="profile[age]" value="{{$data['age'] ?? null}}"
                           placeholder="Укажите свой возраст">
                </div>


                <div class="input-group">
                    <label for="target">Ваша цель участия в программе</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                           value="Восстановление после ОНМК (инсульта)"
                           name="profile[reason][]" id="reason1"
                           @if(in_array('Восстановление после ОНМК (инсульта)',$data['reason'] ?? [])) checked @endif
                    >
                    <label class="form-check-label" for="reason1">
                        Восстановление после ОНМК (инсульта)
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="profile[reason][]"
                           value="Коррекция когнитивных нарушений при деменции"
                           @if(in_array('Коррекция когнитивных нарушений при деменции',$data['reason'] ?? [])) checked
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
                           @if(in_array('Профилактика (ослабления памяти, внимания, мышления или речи)',$data['reason'] ??[])) checked
                           @endif
                           id="reason3">
                    <label class="form-check-label" for="reason3">
                        Профилактика (ослабления памяти, внимания, мышления или речи)
                    </label>
                </div>

                <div class="form-group mt-3">
                    <label for="exampleFormControlSelect1">У вас есть возможность заниматься 3-4 раза в неделю?</label>
                    <select class="form-control" name="profile[workout_per_week]" id="profile[workout_per_week]">
                        <option></option>
                        <option value="1" @if(($data['workout_per_week'] ?? null) == 1) selected @endif>Да</option>
                        <option value="0" @if(($data['workout_per_week'] ?? null) == 0) selected @endif>Нет</option>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="exampleFormControlSelect1">Как будете заниматься?</label>
                    <select class="form-control" name="profile[how]">
                        <option></option>
                        <option value="Самостоятельно" @if(($data['how'] ?? null) == 'Самостоятельно') selected @endif>
                            Самостоятельно
                        </option>
                        <option value="родственником/помощником"
                                @if(($data['how'] ?? null) == 'родственником/помощником') selected @endif>С
                            родственником/помощником
                        </option>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="exampleFormControlSelect1">Если у Вас был инсульт, то какой</label>
                    <select class="form-control" name="profile[insult]">
                        <option></option>
                        <option value="Правосторонний"
                                @if(($data['insult'] ?? null) == 'Правосторонний') selected @endif>Правосторонний
                        </option>
                        <option value="Левосторонний" @if(($data['insult'] ?? null) == 'Левосторонний') selected @endif>
                            Левосторонний
                        </option>
                        <option value="Геморрагический"
                                @if(($data['insult'] ?? null) == 'Геморрагический') selected @endif>Геморрагический
                        </option>
                        <option value="Ишемический" @if(($data['insult'] ?? null) == 'Ишемический') selected @endif>
                            Ишемический
                        </option>
                        <option value="Транзиторная ишемическая атака"
                                @if(($data['insult'] ?? null) == 'Транзиторная ишемическая атака') selected @endif>
                            Транзиторная ишемическая атака
                        </option>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="exampleFormControlSelect1">Если Вы страдаете деменцией, то какого вида:</label>
                    <select class="form-control" name="profile[demension_type]">
                        <option></option>
                        <option value="Болезнь Альцгеймера"
                                @if(($data['demension_type'] ?? null) == 'Болезнь Альцгеймера') selected @endif>Болезнь
                            Альцгеймера
                        </option>
                        <option value="сосудистая деменция"
                                @if(($data['demension_type'] ?? null) == 'сосудистая деменция') selected @endif>
                            сосудистая деменция
                        </option>
                        <option value="лобно-височная деменция"
                                @if(($data['demension_type'] ?? null) == 'лобно-височная деменция') selected @endif>
                            лобно-височная деменция
                        </option>
                        <option value="деменция с тельцами Леви"
                                @if(($data['demension_type'] ?? null) == 'деменция с тельцами Леви') selected @endif>
                            деменция с тельцами Леви
                        </option>
                        <option value="смешанная деменция"
                                @if(($data['demension_type'] ?? null) == 'смешанная деменция') selected @endif>
                            смешанная деменция
                        </option>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="exampleFormControlSelect1">Проходили ли Вы лечение в отделениях
                        нейрореабилитации?</label>
                    <select class="form-control" name="profile[reabilitation]">
                        <option></option>
                        <option value="1" @if(($data['reabilitation'] ?? null) == 1) selected @endif>Да</option>
                        <option value="0" @if(($data['reabilitation'] ?? null) == 0) selected @endif>Нет</option>
                    </select>
                </div>
            </div>
        </div>
        <p class="pb-3">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </p>
    </form>
@endsection
