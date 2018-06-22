<?php

Broadcast::channel('discussions.{discussion}', function (\App\User $user, \App\Discussion $discussion) {
    return $user->can('participate', $discussion);
});

Broadcast::channel('meetings.{meeting}', function (\App\User $user, \App\Meeting $meeting) {
    return $user->can('participate', $meeting->group);
});

Broadcast::channel('members.{member}', function (\App\User $user, \App\Member $member) {
    return $user->can('participate', $member->group);
});

Broadcast::channel('users.{user}', function (\App\User $user, \App\User $target) {
    return $target->id === $user->id;
});

Broadcast::channel('groups.{group}', function (\App\User $user, $target) {
    $group = \App\Group::findOrFail($target);
    return $user->can('facilitate', $group);
});

Broadcast::channel('group.{group}', function (\App\User $user, $target) {
    return true;
});

Broadcast::channel('accounts.{account}', function (\App\User $user, \App\Account $account) {
    return $user->can('manage', $account);
});
