<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Test;
use App\Models\TestGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;


class ExamController extends Controller
{

    public function index()
    {
        $exams = Exam::with(['pack', 'user'])->orderBy('id', 'desc')->paginate(50);
        return view('exam.index')->with('exams', $exams);
    }

}
