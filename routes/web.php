<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\ExamController;
use App\Http\Controllers\admin\ExerciseController;
use App\Http\Controllers\admin\TestPackController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\admin\TestController;
use App\Http\Controllers\admin\TestGroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Models\Exam;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::prefix('admin')->middleware('auth')->middleware('role:ROLE_ADMIN')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');

    Route::get('/run-test/{test}', [TestController::class, 'runTest'])->name('runTest');
    Route::post('/run-test/{test}', [TestController::class, 'runTest'])->name('runTest');
    Route::post('/create-test/{id}', [TestGroupController::class, 'createTest'])->name('createTest');
    Route::post('/check-test/{id}', [TestController::class, 'checkTest'])->name('checkTest');
    Route::resource('test', TestController::class)->only(['edit', 'update', 'destroy']);
    Route::resource('test-group', TestGroupController::class);
    Route::resource('exam', ExamController::class)->only(['index']);
    Route::resource('users', UserController::class);


    Route::post('/exercise/{exercise}/assign', [ExerciseController::class, 'assign'])->name('exercise.assign');
    Route::delete('/exercise/{exercise_rule}/assign-destroy', [ExerciseController::class, 'destroyAssign'])->name('exercise.destroyAssign');
    Route::resource('exercise', ExerciseController::class);


    Route::resource('test-pack', TestPackController::class)->except(['show']);
    Route::post('/test-pack/addTest/{packId}', [TestPackController::class, 'addTest'])->name('test-pack.addTest');
    Route::get('/test-pack/remove-test/{packId}/{testId}', [TestPackController::class, 'destroyTest'])->name('test-pack.destroyTest');
});

Route::get('/run/{id}', [\App\Http\Controllers\front\TestController::class, 'runGroup'])->name('test.runGroup');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::post('/login', [LoginController::class, 'authenticate'])->middleware('guest')->name('auth.login');
Route::get('/register/user', [RegisteredUserController::class, 'create'])->middleware('guest')->name('auth.register');
Route::get('/register/doc', [RegisteredUserController::class, 'createDoc'])->middleware('guest')->name('auth.register_doc');

Route::post('/register/{role}', [RegisteredUserController::class, 'store'])->middleware('guest');


Route::middleware(['auth'])->group(function () {

    Route::get('/exercise/{exercise}/run', [ExerciseController::class, 'run'])->name('exercise.run');


    Route::get('/doctors', [UserController::class, 'doctorsList'])->name('doctors_list');
    Route::get('/patients', [UserController::class, 'patientsList'])->name('patients_list');

    Route::get('/patients/add', [UserController::class, 'patientsAttach'])->name('patients.add');
    Route::post('/patients/add', [UserController::class, 'patientsStore'])->name('patients.add');
    Route::get('/patients/{id}', [UserController::class, 'show'])->name('patients.show');


    Route::get('/msg', [UserController::class, 'messageList'])->name('message.list');
    Route::get('/msg/{id}', [UserController::class, 'viewThread'])->name('message.view');
    Route::get('/msg/send/{id}', [UserController::class, 'createThread'])->name('message.send');
    Route::post('/msg/{thread}', [UserController::class, 'storeMsg'])->name('message.store');

    Route::get('/pack/{testPackId}/run', [HomeController::class, 'run'])->name('test-pack.run');
    Route::get('/test/{examId}', [HomeController::class, 'runExam'])->name('runExam');
    Route::post('/test/{examId}', [HomeController::class, 'runExam'])->name('runExam');
    Route::get('/test/{examId}/complete', [HomeController::class, 'testComplete'])->name('testComplete');

    Route::get('/welcome/first', [WelcomeController::class, 'first'])->name('welcome');
    Route::post('/welcome/store_first', [WelcomeController::class, 'store_first'])->name('welcome.store_first');

    Route::get('/welcome/second', [WelcomeController::class, 'second'])->name('welcome.second');
    Route::post('/welcome/store_second', [WelcomeController::class, 'store_second'])->name('welcome.store_second');
});
