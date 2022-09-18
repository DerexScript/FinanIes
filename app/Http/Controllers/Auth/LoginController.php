<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth as JwtAuth;


class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['verifyLogin']]);
    }

    /**
     * @OA\Post(
     *   tags={"Auth"},
     *   description="login and get authorization key",
     *   summary="login and get authorization key",
     *   path="/api/v1/login",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="credential",
     *           description="Email address or user.",
     *           type="string",
     *           default="user@user.com",
     *         ),
     *         @OA\Property(
     *           property="password",
     *           description="password",
     *           type="string",
     *           default="password123",
     *         ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(response="200", description="An example resource")
     * )
     */

    public function verifyLogin(Request $request)
    {
        $rules = [
            'credential' => 'required',
            'password' => 'required|min:8'
        ];
        $messages = [
            'credential.required' => 'Você precisa informar um e-mail ou usuario valido.',
            'password.required' => 'Você precisa informar uma senha.',
            'password.min' => 'Sua senha precisa ter no minimo 8 caracteres.'
        ];
        $customAttributes = [
            'credential' => 'credential',
            'password' => 'password',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            return response(
                array("success" => false, "data" => array(), "erros" => $validator->errors()),
                400
            )->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE')
                ->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'))
                ->header('Access-Control-Allow-Origin', '*');
        }
        $credentials = $request->only('credential', 'password');
        $user = User::query()->where('email', $credentials["credential"])->orWhere(
            'username',
            $credentials["credential"]
        )->first();
        if ($user && Hash::check($credentials["password"], $user->password)) {
            $token = JwtAuth::attempt(['email' => $user->email, 'password' => $credentials["password"]]);
            return response()->json(
                array(
                    "success" => true, "data" => array(
                        'token' => $token,
                        'token_type' => 'bearer',
                        'expires_in' => JwtAuth::factory()->getTTL() * 60,
                        'user' => $user,
                    ), "erros" => array()
                ),
                200
            )->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE')
                ->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'))
                ->header('Access-Control-Allow-Origin', '*');
        }
        return  response()->json(
            array(
                "success" => false, "data" => array(), "erros" => array("message" => "invalid user or password")
            ),
            401
        )->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE')
            ->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'))
            ->header('Access-Control-Allow-Origin', '*');
    }
}
