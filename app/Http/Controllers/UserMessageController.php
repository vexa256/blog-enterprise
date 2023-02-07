<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use App\MessageThread;
use App\MessageParticipant;
use App\Events\MessageReceived;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserMessageController extends Controller
{

    public function __construct()
    {
        $this->middleware('DemoAdmin', ['only' => ['action']]);
    }

    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function index(User $user)
    {
        $this->authorize('view', $user);

        $threads = MessageThread::forUser(Auth::id())->latest('updated_at')->paginate(10);

        return view('pages.user.messages.index', compact('user', 'threads'));
    }


    /**
     * Shows a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function show(User $user, $id)
    {
        $this->authorize('view', $user);

        try {
            $thread = MessageThread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error.message', trans('message_thread_not_found'));

            return redirect()->route('user.messages', ['user' => $user->username_slug]);
        }

        $thread->markAsRead(Auth::id());

        $messages = $thread->messages()->withTrashed()->oldest('created_at')->paginate(10);

        return view('pages.user.messages.show', compact('user', 'thread', 'messages'));
    }

    /**
     * Mark as read a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function read(User $user, $id)
    {
        $this->authorize('view', $user);

        try {
            $thread = MessageThread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error.message', trans('message_thread_not_found'));

            return redirect()->back();
        }

        $thread->markAsRead(Auth::id());

        return redirect()->back();
    }

    /**
     * Mark as read a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function unread(User $user, $id)
    {
        $this->authorize('view', $user);

        try {
            $thread = MessageThread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error.message', trans('message_thread_not_found'));

            return redirect()->back();
        }

        $thread->markAsUnRead(Auth::id());

        return redirect()->back();
    }

    /**
     * Creates a new message thread.
     *
     * @return mixed
     */
    public function create(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $to_user = null;

        if ($to = $request->get("to")) {
            $to_user = User::bySlug($to)->firstOrFail();
        }

        $users = User::where('id', '!=', Auth::id())->get();

        return view('pages.user.messages.create', compact('user', 'users', 'to_user'));
    }

    /**
     * Stores a new message thread.
     *
     * @return mixed
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $inputs = $request->all();

        $val =  Validator::make(
            $inputs,
            [
                'subject' => 'required|min:1',
                'message' => 'required|max:2000|min:1',
                'recipients' => 'required|max:100',
            ]
        );

        if ($val->fails()) {
            Session::flash('error.message',  $val->errors()->first());

            return redirect()->back()->withInput($inputs);
        }

        $thread = MessageThread::create([
            'subject' => clean($inputs['subject'], 'titles'),
        ]);

        // Message
        $message = Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => clean($inputs['message']),
        ]);

        // Sender
        MessageParticipant::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'last_read' => new Carbon,
        ]);

        // Recipients
        if ($request->has('recipients')) {
            $thread->addParticipant(explode(',', $inputs['recipients']));
        }

        event(new MessageReceived($message));

        return redirect()->action('UserMessageController@index', [$user->username_slug]);
    }

    /**
     * Adds a new message to a current thread.
     *
     * @param $id
     * @return mixed
     */
    public function update(Request $request, User $user, $id)
    {
        $this->authorize('view', $user);

        $inputs = $request->all();

        $val = Validator::make(
            $inputs,
            [
                'message' => 'required|max:2000|min:1',
            ]
        );

        if ($val->fails()) {
            Session::flash('error.message',  $val->errors()->first());
            return redirect()->back()->withInput($inputs);
        }

        try {
            $thread = MessageThread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error.message', trans('message_thread_not_found'));
            return redirect()->back()->withInput($inputs);
        }

        $thread->activateAllParticipants();

        // Message
        $message = Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => clean($request->input('message')),
        ]);

        // Add replier as a participant
        $participant = MessageParticipant::firstOrCreate([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
        ]);
        $participant->last_read = now();
        $participant->save();

        // Recipients
        if ($request->has('recipients')) {
            $thread->addParticipant(explode(',', $request->input('recipients')));
        }

        event(new MessageReceived($message));

        return redirect()->route('user.message.show',  ['user' => $user->username_slug, 'id' => $id]);
    }

    /**
     * Adds a new message to a current thread.
     *
     * @param $id
     * @return mixed
     */
    public function action(Request $request, User $user, $id)
    {
        $this->authorize('view', $user);

        $action = $request->get('action');

        try {
            $thread = MessageThread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error.message', trans('message_thread_not_found'));
            return redirect()->back();
        }

        // to prevent unread messages
        $thread->markAsRead($user->id);

        if ($action === 'leave') {
            $thread->removeParticipant([$user->id]);
        }

        if (Auth::user()->isAdmin()) {
            if ($action === 'delete') {
                $thread->delete();
            }
            if ($action === 'forceDelete') {
                $thread->forceDelete();
            }
        }

        if ($action === 'deleteMessage') {
            $message = $thread->messages()->find($request->get('messageId'));
            if ($message && $message->user_id === $user->id || $message && Auth::user()->isAdmin()) {
                $message->delete();
            }
        }

        if ($action === 'forceDeleteMessage') {
            $message = $thread->messages()->withTrashed()->find($request->get('messageId'));
            if ($message && Auth::user()->isAdmin()) {
                $message->forceDelete();
            }
        }

        if ($action === 'retrieveMessage') {
            $message = $thread->messages()->withTrashed()->find($request->get('messageId'));
            if ($message && Auth::user()->isAdmin()) {
                $message->restore();
            }
        }

        return redirect()->back();
    }
}
