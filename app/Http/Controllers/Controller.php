<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

define("API_HOST", preg_match("/user/i", __DIR__) ? 'http://localhost:8000' : 'https://api.finanies.tk');
/**
 * Class Controller
 * @package App\Http\Controllers
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="FinanIes",
 *         @OA\License(name="MIT"),
 *         @OA\Contact(
 *             email="derex@outlook.com.br"
 *         ),
 *
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
 *        url=API_HOST,
 *        description="API server",
 *     )
 * )
 */

class Controller extends BaseController
{
}
