<?php

$faktory->define(['thread', 'DanSketic\Messenger\Models\Thread'], function ($f) {
    $f->subject = 'Sample thread';
});

$faktory->define(['message', 'DanSketic\Messenger\Models\Message'], function ($f) {
    $f->user_id = 1;
    $f->thread_id = 1;
    $f->body = 'A message';
});

$faktory->define(['participant', 'DanSketic\Messenger\Models\Participant'], function ($f) {
    $f->user_id = 1;
    $f->thread_id = 1;
});
