<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamData;
use App\Models\InitialTest;
use App\Models\IntroTest;
use App\Models\TestGroup;
use App\Models\TestPack;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WelcomeController extends Controller
{
    private function redirectIfNotPatient()
    {
        $user = Auth::user();
        if (!$user) {
            return null;
        }

        if ($user->hasRole(User::ROLE_ADMIN)) {
            return redirect()->route('admin');
        }

        if ($user->hasRole(User::ROLE_DOC)) {
            return redirect()->route('patients_list');
        }

        return null;
    }

    public function first()
    {
        if ($redirect = $this->redirectIfNotPatient()) {
            return $redirect;
        }

        $user = Auth::user();
        $data = $user->jsonData['initial_data'] ?? [];
        $caregiver = $user->getCaregiver();

        return view('welcome.form')->with([
            'data' => $data,
            'caregiver' => $caregiver,
        ]);
    }

    public function store_first(Request $request)
    {
        if ($redirect = $this->redirectIfNotPatient()) {
            return $redirect;
        }

        $validated = $request->validate(
            User::caregiverValidationRules(),
            User::caregiverValidationMessages()
        );

        if ($user = Auth::user()) {
            $jsonData = is_array($user->jsonData) ? $user->jsonData : [];
            $jsonData['initial_data'] = $request->post('profile', []);
            $user->jsonData = $jsonData;
            $user->setCaregiver($validated['caregiver'] ?? []);
            $user->save();
            return redirect()->route('welcome.second');
        }
    }

    public function second()
    {
        if ($redirect = $this->redirectIfNotPatient()) {
            return $redirect;
        }

        $user = Auth::user();
        return view('welcome.new_second_form', ['data' => IntroTest::getData(), 'model' => $user]);
        //return view('welcome.second_form');
    }

    public function store_second(Request $request)
    {
        if ($redirect = $this->redirectIfNotPatient()) {
            return $redirect;
        }

        $result = [];
        foreach (IntroTest::getData() as $key => $block) {
            $arr = $request->post('assign');
            if (isset($arr[$key])) {
                $result[(string)$key] = ((int)$arr[$key]) + 1;
            } else {
                $result[(string)$key] = 0;
            }
        }


//        $result = [];
//
//        foreach ($request->except('_token') as $key => $val) {
//            if ($val === '1' || $val === '2') {
//                $exploded = explode('_', $key);
//                $cat = $exploded[1];
//                $result[$cat] = $val;
//            }
//        }
//

        $user = Auth::user();
        $user->jsonData = array_merge($user->jsonData ?? [], ['results' => $result]);
        $user->save();


//        foreach (TestPack::all() as $tp) {
//            if ($assignArr = $tp->assign) {
//                if(isset($assignArr[])){
//
//                }
//                dd($tp->assign);
//            }
//        }
//
//        dd($result);
//        dd('stop');

        return redirect('/');
    }
}
