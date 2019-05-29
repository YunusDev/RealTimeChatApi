<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Model\Message;
use App\Model\Talk;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    //
    use ApiResponser;

    public function fetchMessages()
    {

        $messages =  Message::with('user', 'talk')->get();

        return $this->showAll($messages);
    }

    public function talkMessages(Talk $talk){

        $messages =  Message::with('user')->where('talk_id', $talk->id)->get();

        return $this->showAll($messages);

    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(User $user, Talk $talk, Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
        ]);

        $message = new Message();

        $message->message = $request->message;
        $message->user_id = $user->id;
        $message->talk_id = $talk->id;

        $message->save();
        broadcast(new MessageSent($user, $message))->toOthers();

        return $this->showOne($message, 201);
    }
}
