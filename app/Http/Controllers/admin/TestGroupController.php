<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\TestGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;


class TestGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $testsgroups = TestGroup::orderBy('id', 'desc')->paginate(25);
        return view('testgroups.index')->with('model', $testsgroups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('testgroups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $group = new TestGroup();
        $group->name = $request->get('name');
        $group->created_by = Auth::user()->id;
        $group->save();

        return redirect(route('test-group.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = TestGroup::find($id);
        return view('testgroups.show')->with('model', $model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = TestGroup::find($id);
        return view('testgroups.edit')->with(['model' => $model]);
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
        $model = TestGroup::find($id);
        $model->fill($request->all());
        $model->save();
        return redirect(route('test-group.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestGroup $testGroup)
    {
        foreach ($testGroup->tests as $test) {
            $test->delete();
        }
        $testGroup->delete();
        return back();
    }

    public function createTest(Request $request, int $id)
    {
        $validated = $request->validate([
            'type' => 'required',
        ]);

        $test = new Test();
        $test->group_id = $id;
        $test->name = $request->get('name');
        $test->type = $request->get('type');
        $test->created_by = Auth::user()->id ?? 0;
        $test->save();

        return redirect()->route('test.edit', $test->id);
    }

    public function run()
    {


    }
}
