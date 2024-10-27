<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class StatisticController extends BaseController
{
    public function stats()
    {
        $stats = Cache::remember('stats', now()->addMinutes(10), function () {
            $stats = [
                'users_total' => User::count(),
                'posts_total' => Post::count(),
                'users_with_no_posts' => User::doesntHave('posts')->count(),
            ];

            return $stats;
        });

        return $this->sendResponse($stats);
    }
}
