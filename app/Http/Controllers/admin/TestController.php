<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\TestGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;


class TestController extends Controller
{
    public function destroy($id)
    {
        Test::find($id)->delete();
        return back();
    }

    public function update(Request $request, $id)
    {
        $model = Test::find($id);

        $model->fill($request->all());


        if ($questionImage = ($request->file('data')['question']['uploadfile'] ?? null)) {
            $current = $model->data;
            $current['question']['image'] = '/' . str_replace('public', 'storage', $questionImage->store('public/questions/' . $id));
            $model->data = $current;
        }
//
        if (isset($request->all()['files']['answers'])) {
            foreach ($request->all()['files']['answers'] as $index => $file) {
                if (isset($file['uploadfile'])) {
                    $current = $model->data;
                    $current['answers'][$index]['image'] = '/' . str_replace('public', 'storage', $file['uploadfile']->store('public/questions/' . $id));
                    $model->data = $current;
                }
            }
        }

        $model->save();
        return redirect(route('test-group.show', $model->group_id));
    }

    public function runTest(Test $test, Request $request)
    {
        $result = null;

        $points = 0;
        $errors = 0;

        if ($request->post('answer')) {
            $result['status'] = 'wrong';

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
                        if (isset($answer['text']) && $answer['text'] === $request->answer) {
                            if ($mark > 0) {
                                $points += $mark;
                                $result['status'] = 'success';
                            } else {
                                $errors += 1;
                            }
                        }
                    }
                }
            }
        }

        $answers = !empty($test->data['answers']) ? collect($test->data['answers'])->shuffle() : collect();

        return view('test.view')->with(['model' => $test, 'result' => $result, 'answers' => $answers, 'points' => $points, 'errors' => $errors]);
    }

    public function checkTest(Request $request)
    {
        return back()->with('success', 'Тест проверен.');
    }

    public function edit($id)
    {
//        $model = Test::find($id);
//
//
//        $data = [];
//        if (isset($model->data['answer'])) {
//            foreach ($model->data['answer'] as $i => $answer) {
//                $data[$i]['answer'] = $answer;
//            }
//        }
//
//        if (isset($model->data['mark'])) {
//            foreach ($model->data['mark'] as $i => $mark) {
//                $data[$i]['mark'] = $mark;
//            }
//        }
//
//        if (isset($model->data['about'])) {
//            foreach ($model->data['about'] as $i => $mark) {
//                $data[$i]['about'] = $mark;
//            }
//        }
//
//        if (empty($data)) {
//            $data = [
//                [], [],
//            ];
//        }
//
//
//        return view('test.edit')->with(['model' => $model, 'data' => $data]);


        $model = Test::find($id);
        return view('test.liveware_form')->with(['model' => $model]);
    }
}
