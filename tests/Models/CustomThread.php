<?php

namespace DanSketic\Messenger\Test\Models;

use DanSketic\Messenger\Models\Message;

class CustomThread extends Message
{
    protected $table = 'custom_threads';
}
