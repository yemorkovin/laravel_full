<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;

class NewsPolicy
{
    public function manageNews(User $user)
    {
        // Только модератор может управлять новостями
        return $user->isModerator();
    }
}
