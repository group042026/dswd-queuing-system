<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Cache;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('id-autofill.{scanSession}', function (User $user, string $scanSession): bool {
    $session = Cache::get("client-id-autofill-session.{$scanSession}");

    return is_array($session)
        && (int) $session['user_id'] === (int) $user->getAuthIdentifier()
        && in_array($session['status'], ['pending', 'processing', 'completed'], true);
});
