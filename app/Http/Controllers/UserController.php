<?php

namespace App\Http\Controllers;

use App\Models\TestGroup;
use App\Models\User;
use App\Models\UserDoctor;
use App\Models\Exam;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(25); // Трюк для получения пагинатора
        return view('users.index')->with('model', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with(['patients', 'exams.pack'])->findOrFail($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function doctorsList()
    {
        $user = Auth::user();
        return view('users.doctors_list')->with(['doctors' => $user->doctors]);
    }

    public function patientsList()
    {
        $user = Auth::user();
        return view('users.patients_list')->with(['patients' => $user->patients]);
    }

    public function messageList()
    {
        $threads = Thread::forUser(Auth::id())->get();
        return view('messenger.threads')->with(['threads' => $threads]);
    }

    public function createThread($id)
    {
        if ($thread = Thread::betweenOnly([Auth::id(), $id])->first()) {

        } else {
            $thread = Thread::create([
                'subject' => "request_from_user",
            ]);

            Participant::create([
                'thread_id' => $thread->id,
                'user_id' => Auth::id(),
                //'last_read' => new Carbon(),
            ]);

            // Recipients
            $thread->addParticipant($id);
        }
        return redirect()->route('message.view', ['id' => $thread->id]);
    }

    public function viewThread($id)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('danger', 'The thread with ID: ' . $id . ' was not found.');
            return redirect()->route('home');
        }

        $userId = Auth::id();
        $to = null;
        foreach ($thread->participantsUserIds($userId) as $user) {
            if ($user != $userId) {
                $to = User::find($user);
            }
        }


        $thread->markAsRead($userId);

        $messages = $thread->messages->sortByDesc('created_at');
        return view('messenger.show', compact('thread', 'to', 'messages'));
    }

    public function storeMsg(Thread $thread, Request $request)
    {
        // Message
        Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $request['message'],
        ]);

        return redirect()->back();
    }

    public function patientsAttach()
    {
        return view('patients.add');
    }

    public function patientsStore(Request $request)
    {
        if ($user = User::where('login', '=', $request->post('ident'))->first()) {
            if (!UserDoctor::where('user_id', '=', $user->id)->where('doctor_id', '=', Auth::id())->first()) {
                UserDoctor::create([
                    'user_id' => $user->id,
                    'doctor_id' => Auth::id(),
                    'comment' => $request->post('comment')
                ]);
            }
        } else {
            Session::flash('danger', 'Пользователь с таким идентификатором не найден.');
        }
        return redirect()->route('patients_list');
    }

}
