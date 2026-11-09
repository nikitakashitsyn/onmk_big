<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\IntroTest;
use App\Models\Test;
use App\Models\TestGroup;
use App\Models\TestPack;
use App\Models\TestPackTest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;


class TestPackController extends Controller
{
    public function index()
    {
        $packs = TestPack::orderBy('id', 'desc')->paginate(25);
        return view('testpack.index')->with('packs', $packs);
    }

    public function create()
    {
        return view('testpack.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $group = new TestPack();
        $group->name = $request->get('name');
        $group->save();

        return redirect(route('test-pack.index'));
    }

    public function edit($id)
    {
        $model = TestPack::find($id);
        return view('testpack.edit')->with(['model' => $model, 'data' => IntroTest::getData()]);
    }

    public function update(Request $request, $id)
    {
        $result = [];
        foreach (IntroTest::getData() as $key => $block) {
            $arr = $request->post('assign');
            if (isset($arr[$key])) {
                $result[(string)$key] = (int)$arr[$key];
            } else {
                $result[(string)$key] = 0;
            }
        }

        $model = TestPack::find($id);
        $model->fill($request->except('assign'));
        $model->assign = $result;
        $model->save();
        return redirect(route('test-pack.index'));
    }

    public function addTest(Request $request, int $packId)
    {
        $model = new TestPackTest();
        $model->test_pack_id = $packId;
        $model->test_id = $request->post('test_id');
        $model->save();
        return back();
    }

    public function destroy(Request $request, TestPack $testPack)
    {
        if (!empty($testPack)) {
            $testPack->delete();
        }
        return back();
    }

    public function destroyTest(Request $request, $packId, $testId)
    {
        $model = TestPackTest::where('test_pack_id', $packId)->where('test_id', $testId)->first();
        if ($model) {
            $model->delete();
        }
        return back();
    }

}
