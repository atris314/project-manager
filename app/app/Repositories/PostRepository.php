<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PostRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function incrementViews(Post $post, $ip) {

        DB::beginTransaction();

        $post = Post::where('id', $post->id)->lockForUpdate()->first();

        $visit = Visit::where('ip',$ip)->where('visitable_type',Post::class)->where('visitable_id',$post->id)->whereDate('created_at', Carbon::now())->first();
        if (!$visit){
            $post->visits()->create([
                'ip' => $ip,
            ]);

            $post->increment('views');
        }
        return $post;
    }
}
