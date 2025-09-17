<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * @OA\Post(
     *      path="/api/v1/profile/update",
     *      operationId="profile.update",
     *     security={{"bearer_token":{}}},
     *      tags={" User Profile"},
     *      summary="افزودن تصویر پروفایل کاربر",
     *      description="کاربر میتواند پروفایل خود را از طریق این اندپوینت تنظیم کند",
     *      @OA\RequestBody(
     *      required=true,
     *      description="",
     *      @OA\JsonContent(
     *          required={"image"},
     *          @OA\Property(property="image", type="file", format="file", example=" "),
     *     ),
     *         @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                 type="object",
     *          required={"image"},
     *         @OA\Property(property="image", type="file", format="file", example=" "),
     *       ),
     *       ),
     * ),
     *      @OA\Response(
     *    response=201,
     *    description="ثبت نام انجام شد",
     *    @OA\JsonContent(
     *       @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV......."),
     *          @OA\Property(property="token_type", type="string", example="bearer"),
     *       @OA\Property(property="user_mobile", type="string", example="09123..."),
     *       @OA\Property(property="message", type="string", example="ثبت نام با موفقیت انجام شد"),
     *        )
     *     ),
     *     @OA\Response(
     *    response=500,
     *    description="خطایی رخ داده است",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string" , example="خطایی رخ داده است"),
     *        )
     *     )
     * )
     */
    public function profileUpdate(UserProfileRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->userService->profileUpdate($request->only('image'));
            DB::commit();
            return $this->sendResponse(Auth::user()->image, 'پروفایل با موفقیت ذخیره شد' ,201);
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
            return $this->sendError($exception->getCode(), 'خطایی رخ داده است' ,500);
        }
    }

}
