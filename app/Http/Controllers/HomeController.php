<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamData;
use App\Models\Exercise;
use App\Models\TestGroup;
use App\Models\TestPack;
use App\Models\UserTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
//    /**
//     * Create a new controller instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        UserTest::reassign();
        $testpacks = UserTest::whereUserId(Auth::id())->get();
        $exams = Exam::where('status', 'created')->where('user_id', Auth::id())->get();
        return view('home', [
            'testpacks' => $testpacks,
            'exams' => $exams,
            'exercises' => Exercise::active()->paginate(),
        ]);
    }

    public function run(Request $request, $testPackId)
    {
        $exam = new Exam();
        $exam->user_id = Auth::id();
        $exam->test_pack_id = $testPackId;
        $exam->status = 'created';
        $exam->save();

        $testPack = TestPack::findOrFail($testPackId);
        foreach ($testPack->tests as $test) {
            $examData = new ExamData();
            $examData->exam_id = $exam->id;
            $examData->test_id = $test->test_id;
            $examData->question = (array)$test->data;
            $examData->answer = [];
            $examData->started_at = 0;
            $examData->ended_at = 0;
            $examData->save();
        }

        return redirect(route('runExam', $exam->id));
    }

    public function runExam(Request $request, $examId)
    {
        $points = 0;
        $errors = 0;
        $result = null;

        $exam = Exam::findOrFail($examId);

        if ($questionId = $request->post('question_id')) {
            $answer = $request->post('answer') ?? [];

            $examData = ExamData::findOrFail($request->post('exam_data_id'));
            $examData->answer = $answer;

            $status = false;

            if ($request->post('answer')) {

                if ($examData->ended_at == 0) {
                    $examData->ended_at = time();
                }

                if ($examData->started_at > 0 && $examData->ended_at > 0) {
                    $examData->elapsed_time = $examData->ended_at - $examData->started_at;
                }

                $examTest = ExamData::where('exam_id', $examId)->where('ended_at', 0)->first();
                $test = $examTest ? $examTest->test : $examData->test;

                $points = 0;
                $errors = 0;

                if (!empty($test->data['answers']) && is_iterable($test->data['answers'])) {
                    foreach ($test->data['answers'] as $answer) {
                        $mark = (float) (str_replace(',', '.', $answer['mark'] ?? 0));

                        if (is_array($request->answer)) {
                            foreach ($request->answer as $a) {
                                if (isset($answer['text']) && $answer['text'] === $a) {
                                    if ($mark > 0) {
                                        $points += $mark;
                                    } else {
                                        $errors += 1;
                                    }
                                }
                            }
                        } else {
                            $isTextMatch = isset($answer['text']) && $answer['text'] === $request->answer;
                            $isImageMatch = !empty($answer['image']) && $answer['image'] === $request->answer;

                            if (($isTextMatch || $isImageMatch) && $mark > 0) {
                                $status = true;
                                $points += $mark;
                                break;
                            } else if ($isTextMatch) {
                                $errors += 1;
                            }
                        }
                    }
                }
            }

            $examData->points = $points;
            $examData->penalty_points = $errors;

            $examData->save();
        }


        $examTest = ExamData::where('exam_id', $examId)->where('ended_at', 0)->first();

        if ($examTest) {
            $test = $examTest->test;

            if (empty($examTest->started_at)) {
                $examTest->update(['started_at' => time()]);
            }

        } else {
            $exam->status = 'ended';
            $exam->update();
            return redirect(route('testComplete', $examId));
        }

        $answers = !empty($test->data['answers']) ? collect($test->data['answers'])->shuffle() : collect();

        return view('test.view')->with(['model' => $test, 'result' => $result, 'examTest' => $examTest, 'answers' => $answers]);

    }

    public function testComplete(Request $request, $examId)
    {
        $exam = Exam::findOrFail($examId);
        return view('test.complete')->with(['model' => $exam]);
    }

}
