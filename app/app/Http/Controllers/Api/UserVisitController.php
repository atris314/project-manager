<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserVisitResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserVisitController extends Controller
{

    /**
     * @OA\Get(
     *      path="/api/v1/post/visited",
     *      operationId="post.visit",
     *     security={{"bearer_token":{}}},
     *      tags={"UserList PostVisit"},
     *      summary="لیستی از کاربران با مجموع بازدید پست هایشان",
     *      description=" لیستی از کاربران با مجموع بازدید پست هایشان",
     *      @OA\Response(
     *    response=200,
     *    description="لیست پست های دیده شده",
     *    @OA\JsonContent(
     *    @OA\Property(property="data", type="array",
     *           @OA\Items(example="")),
     *          @OA\Property(property="server_time", type="string", example=""),
     *       @OA\Property(property="status", type="string", example=""),
     *       @OA\Property(property="message", type="string", example="لیست پست های شما"),
     *        )
     *     )
     * )
     */
    public function index()
    {
        $users = User::query()->withSum('posts', 'views')->orderByDesc('posts_sum_views')
            ->paginate(15);

        return $this->sendResponse(UserVisitResource::collection($users), 'لیست پست‌های دیده‌شده');
    }
}
