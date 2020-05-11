<?php

namespace App\Broadcasting;

use App\User;

class MessagesChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\User  $user
     * @return array|bool
     */
    public function join(User $user, int $task_id)
    {
        return ['channel_id' => $task_id];
    }
}
