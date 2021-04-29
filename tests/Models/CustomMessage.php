<?php

namespace DanSketic\Messenger\Test\Models;

use DanSketic\Messenger\Models\Message;

class CustomMessage extends Message
{
    protected $table = 'custom_messages';
}
