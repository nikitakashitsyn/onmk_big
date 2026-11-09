<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamData;
use App\Models\Excercise;
use App\Models\Exercise;
use App\Models\ExerciseAssignRules;
use App\Models\Test;
use App\Models\TestGroup;
use App\Models\TestPack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/exercise/index', ['items' => Exercise::paginate()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.exercise.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!$request->has('visible')) {
            $request->merge(['visible' => false]);
        } else {
            $request->merge(['visible' => true]);
        }

        $exercise = Exercise::create($request->except('_token'));
        return redirect()->route('exercise.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Exercise $exercise)
    {
        return view('admin.exercise.form', ['model' => $exercise]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!$request->has('visible')) {
            $request->merge(['visible' => false]);
        } else {
            $request->merge(['visible' => true]);
        }

        if ($exercise = Exercise::find($id)) {
            $exercise->fill($request->all());
            $exercise->save();
        }
        return back()->with('success', 'Изменения сохранены!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exercise $exercise)
    {
        $exercise->delete();
        return back()->with('success', 'Запись удалена!');
    }

    public function destroyAssign(ExerciseAssignRules $exercise_rule)
    {
        $exercise_rule->delete();
        return back()->with('success', 'Запись удалена!');
    }

    public function assign(Exercise $exercise, Request $request)
    {
        $jsonData = $request->jsonData;

        $source = explode("_", $request->jsonData['source']) ?? null;
        $jsonData['source_cat'] = $source[0];
        $jsonData['source_el'] = $source[1];

        ExerciseAssignRules::create([
            'exercise_id' => $exercise->id,
            'jsonData' => $jsonData
        ]);
        return redirect()->back()->with('success', 'Изменения сохранены!');
    }

    public function run(Exercise $exercise)
    {
        $userChoises = [];
        if (!empty(Auth::user()->jsonData['results']) && is_iterable(Auth::user()->jsonData['results'])) {
            foreach (Auth::user()->jsonData['results'] as $key => $choice) {
                $userChoises[$key . '_' . ((int)$choice - 1)] = $key . '_' . ((int)$choice - 1);
            }
        }


        $assignArr = [];
        foreach ($exercise->assignRules as $assignRule) {
            if (isset($userChoises[$assignRule->jsonData['source']])) {
                $assignArr[$assignRule->jsonData['target']] = $assignRule->jsonData['qty'];
            }
        }


        if (count($assignArr) > 0) {

            $exam = Exam::create([
                'user_id' => Auth::user()->id,
                'status' => 'created',
                'exercise_id' => $exercise->id,
            ]);

            foreach ($assignArr as $assignCat => $assign_qty) {
                if ($testGroup = TestGroup::find($assignCat)) {
                    foreach ($testGroup->getRandomTest($assign_qty) as $randomTest) {

                        $examData = new ExamData();
                        $examData->exam_id = $exam->id;
                        $examData->test_id = $randomTest->id;
                        $examData->question = (array)$randomTest->data['question'];
                        $examData->answer = [];
                        $examData->started_at = 0;
                        $examData->ended_at = 0;
                        $examData->save();
                    }
                }
            }

            return redirect()->route('runExam', $exam->id);

        } else {
            return back()->with('success', 'По результатам вашего входного тестирования вам не назначено заданий по этому тренажеру.');
        }
    }
}
