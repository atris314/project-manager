<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *      path="/api/v1/register",
     *      operationId="register",
     *      tags={"Register"},
     *      summary="ثبت نام کاربر",
     *      description="ثبت نام",
     *      @OA\RequestBody(
     *      required=true,
     *      description="",
     *      @OA\JsonContent(
     *          required={"mobile","password","email","name"},
     *          @OA\Property(property="mobile", type="number", format="string", example="شماره موبایل مثال : 09123456789"),
     *          @OA\Property(property="password", type="text", format="string", example=" رمز عبور خود را وارد کنید "),
     *          @OA\Property(property="email", type="text", format="string", example=" info@example.com "),
     *          @OA\Property(property="name", type="text", format="string", example=" نام خود را وارد کنید "),
     *     ),
     *         @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                 type="object",
     *          required={"mobile","password","email","name"},
     *          @OA\Property(property="mobile", type="number", format="string", example="شماره موبایل مثال : 09123456789"),
     *          @OA\Property(property="password", type="text", format="string", example=" رمز عبور خود را وارد کنید "),
     *          @OA\Property(property="email", type="text", format="string", example=" info@example.com "),
     *          @OA\Property(property="name", type="text", format="string", example=" نام خود را وارد کنید "),
     *       ),
     *       ),
     * ),
     *       security={{"bearer_token":{}}},
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
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'mobile' => $request['mobile'],
                'password' => bcrypt($request['password']),
            ]);
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'token' => $token,
                'token_type' => 'bearer',
                'user_mobile' => $user->mobile,
                'message' => 'ثبت نام با موفقیت انجام شد'
            ],201);
        }
        catch (Exception $exception)
        {
            return response()->json([
                'message' => 'خطایی رخ داده است'
            ], 500);
        }

    }



    /**
     * @OA\Post(
     *      path="/api/v1/login",
     *      operationId="login",
     *      tags={"Login"},
     *      summary="ورود کاربر",
     *      description="ورود کاربر با استفاده از شماره موبایل و رمز عبور",
     *      @OA\RequestBody(
     *      required=true,
     *      description="",
     *      @OA\JsonContent(
     *          required={"mobile","password"},
     *          @OA\Property(property="mobile", type="number", format="string", example="شماره موبایل مثال : 09123456789"),
     *          @OA\Property(property="password", type="text", format="string", example=" رمز عبور خود را وارد کنید "),
     *     ),
     *         @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                 type="object",
     *                 required={"mobile","password"},
     *          @OA\Property(property="mobile", type="number", format="string", example="شماره موبایل مثال : 09123456789"),
     *          @OA\Property(property="password", type="text", format="string", example=" رمز عبور خود را وارد کنید "),
     *       ),
     *       ),
     * ),
     *       security={{"bearer_token":{}}},
     *      @OA\Response(
     *    response=200,
     *    description="auth",
     *    @OA\JsonContent(
     *       @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV......."),
     *       @OA\Property(property="token_type", type="string", example="bearer"),
     *       @OA\Property(property="expires_in", type="string", example="60"),
     *        )
     *     ),
     *     @OA\Response(
     *    response=401,
     *    description="unauth",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string" , example="شما مجاز نیستید! احراز هویت انجام نشد"),
     *        )
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('mobile', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'message' => 'شما مجاز نیستید! احراز هویت انجام نشد'
            ], 401);
        }
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL()  .'دقیقه'
        ],200);
    }
}
