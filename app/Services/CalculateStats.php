<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class CalculateStats
{
    public static function stats()
    {
        return Cache::remember('stats', now()->addMinutes(10), function () {
            $stats = [
                'users_total' => User::count(),
                'posts_total' => Post::count(),
                'users_with_no_posts' => User::doesntHave('posts')->count(),
            ];

            return $stats;
        });
    }
}
