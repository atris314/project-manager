<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * @OA\Swagger(
     *       basePath="",
     *       schemes={"http", "https"},
     *       host=L5_SWAGGER_CONST_HOST,
     * @OA\Info(
     *      version="1.0.0",
     *      title="GSMpay task api",
     *      description="GSMpay task api Documentation",
     *      @OA\Contact(
     *          email="Farinaz.haghighi314@gmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description=" API Server"
     * )

     *
     * @OA\Tag(
     *     name="Projects",
     *     description=" Api Endpoints"
     * )
     * @OA\Schemes(format="http")
     * @OAS\SecurityScheme(
     *      securityScheme="bearer_token",
     *      type="http",
     *      bearerFormat="JWT",
     *      scheme="bearer"
     * )
     *
     * @OA\PathItem(
     *      path="/"
     *  )
     */
    public function index()
    {
        //
    }


}
