<?php

namespace Modules\Tasks\Observers;

use App\Models\User;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Modules\Tasks\Repositories\ProjectsRepository;

class UserObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $repo = new ProjectsRepository;
        $repo->createDefaultUserProject($user);
    }
}
