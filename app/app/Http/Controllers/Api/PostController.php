<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Visit;
use App\Repositories\PostRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    protected PostRepository $postRepository;
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    /**
     * @OA\Get(
     *      path="/api/v1/post",
     *      operationId="posts",
     *     security={{"bearer_token":{}}},
     *      tags={"Posts"},
     *      summary="پست های کاربر",
     *      description=" لیست پست های کاربر لاگین شده را نمایش میدهد",
     *      @OA\Response(
     *    response=200,
     *    description="نمایش لیست پست های شما",
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
        $posts = Post::where('user_id', Auth::id())->with('user')->paginate(10);
        return $this->sendResponse(PostResource::collection($posts), 'لیست پست‌های شما');
    }



    /**
     * @OA\Get(
     *      path="/api/v1/post/show/{post}",
     *      operationId="post.show",
     *     security={{"bearer_token":{}}},
     *      tags={"Post Detaile"},
     *      summary="اطلاعات یک پست",
     *      description=" نمایش اطلاعات یک پست",
     *       @OA\Parameter(
     *            name="post",
     *            description="post id",
     *            required=true,
     *            in="path",
     *            example="1",
     *            @OA\Schema(
     *                type="string"
     *            )
     *        ),
     *      @OA\Response(
     *    response=200,
     *    description="نمایش اطلاعات پست",
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
    public function show(Post $post)
    {
        try {
            $post = $this->postRepository->incrementViews($post, request()->ip());
            DB::commit();
            return $this->sendResponse(PostResource::make($post), 'نمایش اطلاعات پست');

        } catch (Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getCode(), 'خطایی رخ داده است' ,500);
        }

    }

}
