<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class HelperController extends Controller
{
    /**
     * @OA\Get(
     *   tags={"Helpers"},
     *   description="get framework version",
     *   summary="get framework version",
     *   path="/api/v1/helpers/version",
     *   @OA\Response(response="200", description="An example resource")
     * )
     */
    public function version()
    {
        return response(
            array("success" => true, "data" => array("version" => App::VERSION()), "erros" => array()),
            200
        );
    }

    /**
     * @OA\Get(
     *   tags={"Helpers"},
     *   description="get all routes",
     *   summary="get all routes",
     *   path="/api/v1/helpers/routes",
     *   @OA\Response(response="200", description="An example resource")
     * )
     */
    public function getRoutes()
    {
        $routes = [];
        $rrr = Route::getRoutes();
        foreach ($rrr as $route) {
            if (array_key_exists('as', $route['action'])) {
                $routes[] = $route['action']['as'];
            }
        }
        return response(
            array("success" => true, "data" => $routes, "erros" => array()),
            200
        );
    }
}
