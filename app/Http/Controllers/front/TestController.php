<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\TestGroup;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function runGroup($id)
    {
       return redirect('/')->with('info', 'Данный раздел находится в разработке');
    }
}
