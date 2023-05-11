<?php

namespace App\Policies;

use App\Models\CloudflareRecord;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CloudflareRecordPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CloudflareRecord $cloudflareRecord): bool
    {
        return $user->hasTeamPermission($cloudflareRecord->team, 'view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasTeamPermission($user->currentTeam, 'create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CloudflareRecord $cloudflareRecord): bool
    {
        return $user->hasTeamPermission($cloudflareRecord->team, 'update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CloudflareRecord $cloudflareRecord): bool
    {
        return $user->hasTeamPermission($cloudflareRecord->team, 'delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CloudflareRecord $cloudflareRecord): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CloudflareRecord $cloudflareRecord): bool
    {
        //
    }
}
