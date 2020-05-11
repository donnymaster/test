<?php

namespace App\Http\Controllers;

use App\Events\MessageSentModerator;
use App\ModeratorMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ObsceneCensorRus;

class ModeratorMessageController extends Controller
{

    public function fetchMessagesModerator($id)
    {
        return ModeratorMessage::where('broadcast_id', '=', $id)->with('user')->get();
    }


    public function sendMessageModerator(Request $request)
    {

        $user = Auth::user();

        $message = $user->moderator_message()->create([
            'message' => ObsceneCensorRus::getFiltered($request->input('message')),
            'user_id' => Auth::user()->id,
            'broadcast_id' => $request->input('broadcast_id')
        ]);

        broadcast(new MessageSentModerator($user, $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }


}
