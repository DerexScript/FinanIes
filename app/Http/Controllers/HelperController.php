<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

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
}
