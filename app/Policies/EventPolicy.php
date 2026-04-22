<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function update(User $user, Event $event): bool
    {
        return $user->hasRole('admin') || $event->created_by === $user->id;
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->hasRole('admin') || $event->created_by === $user->id;
    }
}
