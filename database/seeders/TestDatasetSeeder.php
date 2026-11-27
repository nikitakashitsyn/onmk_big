<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\ExamData;
use App\Models\Exercise;
use App\Models\Test;
use App\Models\TestPack;
use App\Models\User;
use App\Models\UserDoctor;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestDatasetSeeder extends Seeder
{
    /**
     * Общий пароль для демо-аккаунтов.
     */
    private const DEMO_PASSWORD = 'password123';

    /**
     * Запустить сидер тестовой выборки (идемпотентно).
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::transaction(function () use ($now) {
            $doctor = $this->upsertUser([
                'login' => '900000',
                'name' => 'Смирнова Елена Викторовна',
                'email' => 'doctor.demo@onmk.local',
                'password' => Hash::make(self::DEMO_PASSWORD),
                'roles' => [User::ROLE_DOC],
            ], $now->copy()->subDays(20));

            $patientsConfig = [
                [
                    'attributes' => [
                        'login' => '900001',
                        'name' => 'Иванов Алексей Петрович',
                        'email' => 'patient1.demo@onmk.local',
                        'password' => Hash::make(self::DEMO_PASSWORD),
                        'roles' => [User::ROLE_USER],
                        'jsonData' => [
                            'initial_data' => [
                                'sex' => '1',
                                'age' => '58',
                                'reason' => ['Восстановление после ОНМК (инсульта)'],
                                'workout_per_week' => '1',
                                'how' => 'Самостоятельно',
                                'insult' => 'Ишемический',
                                'demension_type' => '',
                                'reabilitation' => '1',
                            ],
                            'results' => [
                                '0' => 2,
                                '1' => 3,
                                '2' => 4,
                                '3' => 3,
                                '4' => 4,
                                '5' => 2,
                            ],
                            'caregiver' => [
                                'name' => null,
                                'relation' => null,
                                'phone' => null,
                                'email' => null,
                            ],
                        ],
                    ],
                    'created_at' => $now->copy()->subDays(15),
                    'doctor_comment' => 'Демо-пациент №1: восстановление памяти и речи после ишемического ОНМК',
                    'sessions' => [
                        ['key' => 'p1_d13', 'days_ago' => 13, 'hour' => 10, 'questions' => 5, 'correct' => 2, 'avg_sec' => 40],
                        ['key' => 'p1_d11', 'days_ago' => 11, 'hour' => 11, 'questions' => 6, 'correct' => 3, 'avg_sec' => 34],
                        ['key' => 'p1_d09', 'days_ago' => 9,  'hour' => 10, 'questions' => 5, 'correct' => 3, 'avg_sec' => 29],
                        ['key' => 'p1_d07', 'days_ago' => 7,  'hour' => 12, 'questions' => 6, 'correct' => 4, 'avg_sec' => 24],
                        ['key' => 'p1_d05', 'days_ago' => 5,  'hour' => 11, 'questions' => 5, 'correct' => 4, 'avg_sec' => 20],
                        ['key' => 'p1_d03', 'days_ago' => 3,  'hour' => 15, 'questions' => 6, 'correct' => 5, 'avg_sec' => 16],
                        ['key' => 'p1_d01', 'days_ago' => 1,  'hour' => 10, 'questions' => 6, 'correct' => 6, 'avg_sec' => 13],
                    ],
                ],
                [
                    'attributes' => [
                        'login' => '900002',
                        'name' => 'Козлова Мария Сергеевна',
                        'email' => 'patient2.demo@onmk.local',
                        'password' => Hash::make(self::DEMO_PASSWORD),
                        'roles' => [User::ROLE_USER],
                        'jsonData' => [
                            'initial_data' => [
                                'sex' => '2',
                                'age' => '64',
                                'reason' => [
                                    'Восстановление после ОНМК (инсульта)',
                                    'Профилактика (ослабления памяти, внимания, мышления или речи)',
                                ],
                                'workout_per_week' => '1',
                                'how' => 'родственником/помощником',
                                'insult' => 'Левосторонний',
                                'demension_type' => '',
                                'reabilitation' => '1',
                            ],
                            'results' => [
                                '0' => 3,
                                '1' => 4,
                                '2' => 3,
                                '3' => 4,
                                '4' => 3,
                                '5' => 3,
                            ],
                            'caregiver' => [
                                'name' => 'Козлова Ольга Дмитриевна',
                                'relation' => 'Дочь',
                                'phone' => '+7 (916) 555-34-12',
                                'email' => 'caregiver2.demo@onmk.local',
                            ],
                        ],
                    ],
                    'created_at' => $now->copy()->subDays(14),
                    'doctor_comment' => 'Демо-пациент №2: тренировка внимания и восприятия с помощником',
                    'sessions' => [
                        ['key' => 'p2_d12', 'days_ago' => 12, 'hour' => 14, 'questions' => 5, 'correct' => 2, 'avg_sec' => 38],
                        ['key' => 'p2_d09', 'days_ago' => 9,  'hour' => 16, 'questions' => 6, 'correct' => 3, 'avg_sec' => 32],
                        ['key' => 'p2_d06', 'days_ago' => 6,  'hour' => 11, 'questions' => 6, 'correct' => 4, 'avg_sec' => 25],
                        ['key' => 'p2_d04', 'days_ago' => 4,  'hour' => 15, 'questions' => 5, 'correct' => 4, 'avg_sec' => 19],
                        ['key' => 'p2_d01', 'days_ago' => 1,  'hour' => 12, 'questions' => 5, 'correct' => 5, 'avg_sec' => 15],
                    ],
                ],
            ];

            $exercises = Exercise::active()->orderBy('id')->get();
            if ($exercises->isEmpty()) {
                $exercises = Exercise::orderBy('id')->get();
            }

            $packs = TestPack::has('tests.test')
                ->with(['tests.test'])
                ->orderBy('id')
                ->get();

            $fallbackTests = Test::whereNotNull('data')
                ->orderBy('id')
                ->limit(30)
                ->get();

            foreach ($patientsConfig as $config) {
                $patient = $this->upsertUser($config['attributes'], $config['created_at']);

                UserDoctor::updateOrCreate(
                    [
                        'user_id' => $patient->id,
                        'doctor_id' => $doctor->id,
                    ],
                    [
                        'comment' => $config['doctor_comment'],
                    ]
                );

                if ($packs->isEmpty() && $fallbackTests->isEmpty()) {
                    $this->command?->warn(
                        'TestDatasetSeeder: в БД отсутствуют тестовые задания (tests/test_packs), история тренировок пропущена.'
                    );
                    continue;
                }

                $this->seedSessionsForPatient(
                    $patient,
                    $config['sessions'],
                    $exercises,
                    $packs,
                    $fallbackTests,
                    $now
                );
            }
        });
    }

    /**
     * Создать или обновить пользователя по стабильному email/login без дублей.
     */
    private function upsertUser(array $attributes, Carbon $defaultCreatedAt): User
    {
        $user = User::where('email', $attributes['email'])
            ->orWhere('login', $attributes['login'])
            ->first();

        $isNew = !$user;
        if ($isNew) {
            $user = new User();
        }

        $existingJson = is_array($user->jsonData) ? $user->jsonData : [];
        if (isset($attributes['jsonData']) && is_array($attributes['jsonData'])) {
            $attributes['jsonData'] = array_merge($existingJson, $attributes['jsonData']);
        }

        $user->fill($attributes);

        if ($isNew) {
            $user->created_at = $defaultCreatedAt;
            $user->updated_at = $defaultCreatedAt;
            $user->save(['timestamps' => false]);
        } else {
            $user->save();
        }

        return $user;
    }

    /**
     * Идемпотентно создать историю завершённых тренировок для пациента.
     */
    private function seedSessionsForPatient(
        User $patient,
        array $sessions,
        Collection $exercises,
        Collection $packs,
        Collection $fallbackTests,
        Carbon $now
    ): void {
        $jsonData = is_array($patient->jsonData) ? $patient->jsonData : [];
        $demoExamIds = isset($jsonData['demo_exam_ids']) && is_array($jsonData['demo_exam_ids'])
            ? $jsonData['demo_exam_ids']
            : [];

        $changed = false;

        foreach ($sessions as $idx => $session) {
            $sessionKey = $session['key'];
            $existingExamId = $demoExamIds[$sessionKey] ?? null;

            $exam = $existingExamId
                ? Exam::where('id', $existingExamId)->where('user_id', $patient->id)->first()
                : null;

            if ($exam && $exam->tests()->exists()) {
                continue;
            }

            $sessionStart = $now->copy()
                ->subDays($session['days_ago'])
                ->setTime($session['hour'], ($idx * 11) % 50, 0);

            $pack = $packs->isNotEmpty()
                ? $packs->get($idx % $packs->count())
                : null;

            $exercise = $exercises->isNotEmpty()
                ? $exercises->first()
                : null;

            $selectedTests = $this->pickTestsForSession(
                $pack,
                $fallbackTests,
                $session['questions'],
                $idx
            );

            if ($selectedTests->isEmpty()) {
                continue;
            }

            if (!$exam) {
                $exam = new Exam();
                $exam->user_id = $patient->id;
                $exam->test_pack_id = $pack ? $pack->id : null;
                $exam->exercise_id = $exercise ? $exercise->id : null;
                $exam->status = 'ended';
                $exam->created_at = $sessionStart;
                $exam->updated_at = $sessionStart;
                $exam->save(['timestamps' => false]);
            }

            $cursorTs = $sessionStart->timestamp;
            $correctQuota = min($session['correct'], $selectedTests->count());

            foreach ($selectedTests->values() as $qIndex => $test) {
                $isCorrect = $qIndex < $correctQuota;
                $elapsed = max(6, $session['avg_sec'] + (($qIndex % 3) - 1) * 4);
                $startedAt = $cursorTs;
                $endedAt = $startedAt + $elapsed;
                $cursorTs = $endedAt + 2;

                [$answerPayload, $points, $penalty] = $this->buildAnswerResult($test, $isCorrect);

                $examData = new ExamData();
                $examData->exam_id = $exam->id;
                $examData->test_id = $test->id;
                $examData->question = (array) ($test->data['question'] ?? $test->data ?? []);
                $examData->answer = $answerPayload;
                $examData->points = $points;
                $examData->penalty_points = $penalty;
                $examData->started_at = $startedAt;
                $examData->ended_at = $endedAt;
                $examData->elapsed_time = $elapsed;
                $examData->created_at = Carbon::createFromTimestamp($startedAt);
                $examData->updated_at = Carbon::createFromTimestamp($endedAt);
                $examData->save(['timestamps' => false]);
            }

            $exam->updated_at = Carbon::createFromTimestamp($cursorTs);
            $exam->save(['timestamps' => false]);

            $demoExamIds[$sessionKey] = $exam->id;
            $changed = true;
        }

        if ($changed) {
            $jsonData['demo_exam_ids'] = $demoExamIds;
            $patient->jsonData = $jsonData;
            $patient->save(['timestamps' => false]);
        }
    }

    /**
     * Подобрать реальные тесты для тренировки (из пакета и общего пула).
     */
    private function pickTestsForSession(
        ?TestPack $pack,
        Collection $fallbackTests,
        int $desiredCount,
        int $offset
    ): Collection {
        $pool = collect();

        if ($pack) {
            $packTests = $pack->tests
                ->pluck('test')
                ->filter()
                ->values();
            $pool = $pool->merge($packTests);
        }

        if ($pool->count() < $desiredCount && $fallbackTests->isNotEmpty()) {
            $existingIds = $pool->pluck('id')->all();
            $rotated = $fallbackTests
                ->slice($offset % $fallbackTests->count())
                ->merge($fallbackTests->take($offset % $fallbackTests->count()));

            foreach ($rotated as $test) {
                if (!in_array($test->id, $existingIds, true)) {
                    $pool->push($test);
                    $existingIds[] = $test->id;
                }
                if ($pool->count() >= $desiredCount) {
                    break;
                }
            }
        }

        return $pool->take($desiredCount);
    }

    /**
     * Сформировать реалистичный ответ и баллы на основе структуры Test::$data.
     *
     * @return array{0: mixed, 1: float, 2: int}
     */
    private function buildAnswerResult(Test $test, bool $isCorrect): array
    {
        $answers = $test->data['answers'] ?? [];

        if (is_array($answers) && !empty($answers)) {
            $correctOption = null;
            $wrongOption = null;

            foreach ($answers as $option) {
                $mark = (float) str_replace(',', '.', (string) ($option['mark'] ?? 0));
                if ($mark > 0 && $correctOption === null) {
                    $correctOption = $option;
                } elseif ($mark <= 0 && $wrongOption === null) {
                    $wrongOption = $option;
                }
            }

            $chosen = $isCorrect ? ($correctOption ?? reset($answers)) : ($wrongOption ?? reset($answers));
            $value = $chosen['text'] ?? ($chosen['image'] ?? '');
            $isMultiple = isset($test->data['question']['multiple']) && (string) $test->data['question']['multiple'] === '1';
            $payload = $isMultiple ? [$value] : $value;

            if ($isCorrect) {
                $mark = (float) str_replace(',', '.', (string) ($chosen['mark'] ?? 1));
                return [$payload, $mark > 0 ? $mark : 1.0, 0];
            }

            return [$payload, 0.0, 1];
        }

        return [$isCorrect ? 'Верно' : 'Ошибка', $isCorrect ? 1.0 : 0.0, $isCorrect ? 0 : 1];
    }
}
