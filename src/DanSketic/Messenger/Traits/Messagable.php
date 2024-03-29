<?php

namespace DanSketic\Messenger\Traits;

use DanSketic\Messenger\Models\Message;
use DanSketic\Messenger\Models\Models;
use DanSketic\Messenger\Models\Participant;
use DanSketic\Messenger\Models\Thread;

trait Messagable
{
    /**
     * Message relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Models::classname(Message::class));
    }

    /**
     * Participants relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany(Models::classname(Participant::class));
    }

    /**
     * Thread relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function threads()
    {
        return $this->belongsToMany(
            Models::classname(Thread::class),
            Models::table('participants'),
            'user_id',
            'thread_id'
        );
    }

    /**
     * Returns the new messages count for user.
     *
     * @return int
     */
    public function newThreadsCount()
    {
        return $this->threadsWithNewMessages()->count();
    }

    /**
     * Returns all threads with new messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function threadsWithNewMessages()
    {
        return $this->threads()
            ->where(function ($q) {
                $q->whereNull(Models::table('participants') . '.last_read');
                $q->orWhere(Models::table('threads') . '.updated_at', '>', $this->getConnection()->raw($this->getConnection()->getTablePrefix() . Models::table('participants') . '.last_read'));
            })->get();
    }

    /**
     * Returns the new messages count for user.
     *
     * @return int
     */
    public function unreadMessagesCount()
    {
        return Message::unreadForUser($this->getKey())->count();
    }
}
