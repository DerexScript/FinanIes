<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * Class Controller
 * @package App\Http\Controllers
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="FinanIes",
 *         @OA\License(name="MIT")
 *     ),
 *     @OA\Server(
 *         description="API server",
 *         url="https://api.finanies.tk/",
 *     ),
 *     @OA\Components(
 *         @OA\SecurityScheme(
 *         securityScheme="bearerAuth",
 *         type="http",
 *             scheme="Bearer",
 *         ),
 *         @OA\Attachable
 *     ),
 *     @OA\Server(
 *     url="http://api.finanies.tk/",
 *     description="API server http",
 *         @OA\ServerVariable(
 *             serverVariable="schema",
 *             enum={"https", "http"},
 *             default="https"
 *         )
 *     )
 * )
 */

class Controller extends BaseController
{
    //
}
