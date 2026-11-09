@extends('layouts.admin-top-sidebar')

@section('title')
    Основные жалобы
@endsection

@section("content")

    <form method="post" action="{{route('welcome.store_second')}}">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="input-group">
                    <label for="target">Нарушения восприятия</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_1" id="q11" value="0" checked>
                    <label class="form-check-label" for="q11">
                        нет
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_1" id="q12" value="1">
                    <label class="form-check-label" for="q12">
                        Иногда не узнаю знакомые объекты (предметы или люди), если вижу их не полностью или с необычного
                        ракурса
                        (например, не сразу узнаю очки, которые наполовину прикрыты платочком, и т.п.)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_1" id="q13" value="1">
                    <label class="form-check-label" for="q13">
                        Трудно распознать объект при движении
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_1" id="q14" value="2">
                    <label class="form-check-label" for="q14">
                        Не узнаю нарисованные объекты (например, распознаю кошку в наглядном виде или на фото, а на
                        рисунке -
                        нет)
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_1" id="q15" value="2">
                    <label class="form-check-label" for="q15">
                        Не узнаю предметы и лица, он напоминают геометрические фигуры или пятна
                    </label>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="input-group">
                    <label for="target">Нарушения внимания</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_2" id="q21" value="0" checked>
                    <label class="form-check-label" for="q21">
                        нет
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_2" id="q22" value="1">
                    <label class="form-check-label" for="q22">
                        Рассеянность, трудно сконцентрироваться длительно на какой-либо задаче
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_2" id="q23" value="1">
                    <label class="form-check-label" for="q23">
                        Невнимательность, не замечаю нужный предмет или знакомого прямо перед собой
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_2" id="q24" value="2">
                    <label class="form-check-label" for="q24">
                        Внимание постоянно «скачет», не могу удержать его на чем-либо
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_2" id="q25" value="2">
                    <label class="form-check-label" for="q25">
                        Совсем не могу сконцентрироваться, часто теряюсь, что нужно сделать, зачем и куда иду
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_2" id="q26" value="2">
                    <label class="form-check-label" for="q26">
                        Не могу отвлечься, переключиться на новый объект внимания
                    </label>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <div class="input-group">
                    <label for="target">Нарушения памяти</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_3" id="q31" value="0" checked>
                    <label class="form-check-label" for="q31">
                        нет
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_3" id="q32" value="1">
                    <label class="form-check-label" for="q32">
                        Внезапно забываю хорошо известную мне информацию (имена или фамилии знакомых, известных людей,
                        названия городов или стран, животных и т.п.), вспоминаю только через некоторое время
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_3" id="q33" value="1">
                    <label class="form-check-label" for="q33">
                        Забывчивость, часто забываю «мелкие» дела, второстепенные события (основные обязанности, дела,
                        события помню и выполняю)
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_3" id="q34" value="2">
                    <label class="form-check-label" for="q34">
                        Забываю выполнить повседневные дела (почистить зубы, умыться, заправить кровать, купить нужные
                        продукты и т.п.)
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_3" id="q35" value="2">
                    <label class="form-check-label" for="q35">
                        Забываю недавние события, а события из детства и юности помню хорошо, даже с подробностями
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_3" id="q36" value="2">
                    <label class="form-check-label" for="q36">
                        Забываю, что мне сказали несколько минут назад
                    </label>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="input-group">
                    <label for="target">Нарушения мышления</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_4" id="q41" value="0" checked>
                    <label class="form-check-label" for="q41">
                        нет
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_4" id="q42" value="2">
                    <label class="form-check-label" for="q42">
                        Испытываю трудности в решении обычных арифметических задач
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_4" id="q43" value="2">
                    <label class="form-check-label" for="q43">
                        Не могу переключиться на другую мысль
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_4" id="q44" value="2">
                    <label class="form-check-label" for="q44">
                        Не могу понять смысл пословиц, поговорок, и даже сюжетных картинок
                    </label>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <div class="input-group">
                    <label for="target">Двигательные нарушения</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_5" id="q51" value="0" checked>
                    <label class="form-check-label" for="q51">
                        нет
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_5" id="q52" value="1">
                    <label class="form-check-label" for="q52">
                        Слабость в руках или ногах:
                        <ul>
                            <li>на правой стороне тела</li>
                            <li>на левой стороне тела</li>
                            <li>только в руках</li>
                            <li> только в ногах</li>
                        </ul>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_5" id="q53" value="1">
                    <label class="form-check-label" for="q53">
                        Нарушение движений руки (тремор, неловкие движения, нарушение захвата руки и прочее):
                        <ul>
                            <li>правой</li>
                            <li>левой</li>
                            <li>обеих рук</li>
                        </ul>
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_5" id="q54" value="2">
                    <label class="form-check-label" for="q54">
                        Нарушение письма
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_5" id="q55" value="2">
                    <label class="form-check-label" for="q55">
                        Нарушение координации
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_5" id="q56" value="2">
                    <label class="form-check-label" for="q56">
                        Нарушение походки
                    </label>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <div class="input-group">
                    <label for="target">Нарушения речи</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_6" id="q61" value="0" checked>
                    <label class="form-check-label" for="q61">
                        нет
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_6" id="q62" value="1">
                    <label class="form-check-label" for="q62">
                        Испытываю затруднение при назывании чего-либо/кого-либо (вижу или вспоминаю знакомый
                        предмет/фамилию, название “вертится на языке”, но не могу назвать какое-то время
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_6" id="q63" value="2">
                    <label class="form-check-label" for="q63">
                        Мне трудно задать вопрос или высказать мысль, но могу правильно ответить на заданный мне вопрос
                        или повторить отдельные слова или даже предложения
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_6" id="q64" value="2">
                    <label class="form-check-label" for="q64">
                        Могу говорить, но даже близкие люди с трудом понимают мою речь
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_6" id="q65" value="2">
                    <label class="form-check-label" for="q65">
                        Могу говорить, но получается отрывисто, как «телеграфная» речь
                    </label>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <div class="input-group">
                    <label for="target">Блок без названия ???</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_7" id="q71" value="0" checked>
                    <label class="form-check-label" for="q71">
                        нет
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_7" id="q72" value="2">
                    <label class="form-check-label" for="q72">
                        Мне трудно понимать чужую речь, она похожа на поток звуков
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_7" id="q73" value="2">
                    <label class="form-check-label" for="q73">
                        Не могу повторить за кем-то слово
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_7" id="q74" value="2">
                    <label class="form-check-label" for="q74">
                        Говорю много, торопливо, с множественными ошибками, похоже на «словесную окрошку»
                    </label>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="input-group">
                    <label for="target">Блок без названия 2 ???</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_8" id="q81" value="0" checked>
                    <label class="form-check-label" for="q81">
                        нет
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_8" id="q82" value="2">
                    <label class="form-check-label" for="q82">
                        Могу говорить, но трудно понять прочитанное; путаю, что за чем следует
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_8" id="q83" value="2">
                    <label class="form-check-label" for="q83">
                        Могу повторить слово или фразу за кем-то, но плохо понимаю смысл сказанного; могу читать
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="q_8" id="q84" value="2">
                    <label class="form-check-label" for="q84">
                        Понимаю речь, хочу ответить, но не получается сказать
                    </label>
                </div>
            </div>
        </div>


        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

@endsection
