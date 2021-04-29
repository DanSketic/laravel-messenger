<?php

return [

    'user_model' => App\User::class,

    'message_model' => DanSketic\Messenger\Models\Message::class,

    'participant_model' => DanSketic\Messenger\Models\Participant::class,

    'thread_model' => DanSketic\Messenger\Models\Thread::class,

    /**
     * Define custom database table names.
     */
    'messages_table' => null,

    'participants_table' => null,

    'threads_table' => null,
];
