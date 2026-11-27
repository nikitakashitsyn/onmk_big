<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Whitelist маршрутных сегментов → внутренних ролей
    |--------------------------------------------------------------------------
    | Только эти два значения допустимы в URL /register/{role}.
    | Любое другое значение (admin, superuser, …) вернёт 404 / abort(404).
    */
    private const ROLE_MAP = [
        'user' => User::ROLE_USER,
        'doc'  => User::ROLE_DOC,
    ];

    /* ------------------------------------------------------------------ */
    /*  Показ формы                                                        */
    /* ------------------------------------------------------------------ */

    /**
     * Форма регистрации пациента.
     */
    public function create()
    {
        return view('auth.register', ['login' => User::getAvailableLogin()]);
    }

    /**
     * Форма регистрации врача.
     */
    public function createDoc()
    {
        return view('auth.register_doc');
    }

    /* ------------------------------------------------------------------ */
    /*  Обработка POST                                                     */
    /* ------------------------------------------------------------------ */

    /**
     * Зарегистрировать нового пользователя.
     *
     * @param  Request $request
     * @param  string  $role   Сегмент URL: «user» или «doc»
     */
    public function store(Request $request, string $role)
    {
        // 1. Проверяем, что сегмент URL — разрешённый
        if (! array_key_exists($role, self::ROLE_MAP)) {
            abort(404);
        }

        $isDoctor = $role === 'doc';

        // 2. Нормализация email до валидации (trim + lower, пустая строка -> null)
        $rawMail = $request->input('mail');
        if (is_string($rawMail)) {
            $normalizedMail = mb_strtolower(trim($rawMail));
            $request->merge([
                'mail' => $normalizedMail === '' ? null : $normalizedMail,
            ]);
        }

        // 3. Валидация (общие + ролевые правила)
        $request->validate(
            $this->rules($isDoctor),
            $this->messages()
        );

        // 4. Создание пользователя
        $user = $this->createUser($request, $isDoctor);

        // 5. Временные свойства для уведомления (не пишутся в БД)
        $user->passw = $request->password;
        $user->mail  = $request->mail;

        // 6. Событие + авторизация + редирект
        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('welcome');
    }

    /* ------------------------------------------------------------------ */
    /*  Правила валидации                                                  */
    /* ------------------------------------------------------------------ */

    /**
     * Вернуть массив правил валидации.
     */
    private function rules(bool $isDoctor): array
    {
        $rules = [
            // Общие
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'mail'     => [
                $isDoctor ? 'required' : 'nullable',
                'string',
                'email:rfc,filter',
                'max:255',
                Rule::unique('users', 'email'),
            ],
        ];

        if ($isDoctor) {
            // Врач: обязательные ФИО
            $rules['name'] = ['required', 'string', 'min:6', 'max:255'];
        } else {
            // Пациент: обязательный логин (6 цифр, уникальный)
            $rules['login'] = [
                'required',
                'string',
                'regex:/^\d{6}$/',
                Rule::unique('users', 'login'),
            ];
        }

        return $rules;
    }

    /**
     * Сообщения об ошибках на русском языке.
     */
    private function messages(): array
    {
        return [
            'name.required'      => 'Укажите Ф.И.О.',
            'name.min'           => 'Ф.И.О. должно содержать не менее :min символов.',
            'name.max'           => 'Ф.И.О. не должно превышать :max символов.',
            'login.required'     => 'Логин обязателен.',
            'login.regex'        => 'Логин должен состоять из 6 цифр.',
            'login.unique'       => 'Этот логин уже занят.',
            'mail.required'      => 'Укажите адрес электронной почты.',
            'mail.string'        => 'Адрес электронной почты должен быть строкой.',
            'mail.email'         => 'Введите корректный адрес электронной почты.',
            'mail.max'           => 'Адрес электронной почты не должен превышать :max символов.',
            'mail.unique'        => 'Пользователь с таким адресом электронной почты уже зарегистрирован.',
            'password.required'  => 'Введите пароль.',
            'password.min'       => 'Пароль должен содержать не менее :min символов.',
            'password.confirmed' => 'Пароли не совпадают.',
        ];
    }

    /* ------------------------------------------------------------------ */
    /*  Создание пользователя                                              */
    /* ------------------------------------------------------------------ */

    /**
     * Создать запись User в БД с корректной ролью.
     */
    private function createUser(Request $request, bool $isDoctor): User
    {
        $data = [
            'password' => Hash::make($request->password),
        ];

        if ($isDoctor) {
            $data['login'] = User::getAvailableLogin();
            $data['name']  = trim($request->name);
            $data['email'] = $request->mail;
            $data['roles'] = [User::ROLE_DOC];
        } else {
            $data['login'] = $request->login;
            $data['roles'] = [User::ROLE_USER];
            // email необязателен для пациента
            if ($request->filled('mail')) {
                $data['email'] = $request->mail;
            }
        }

        return User::create($data);
    }
}
