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
            )->header('Content-Type', 'application/json; charset=UTF-8')
                ->header('Access-Control-Allow-Methods', '*')
                ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding')
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
                        'expires_in' => JwtAuth::factory()->getTTL() * 60
                    ), "erros" => array()
                ),
                200
            )->header('Access-Control-Allow-Origin', '*')
                ->header('Content-Type', 'application/json; charset=UTF-8')
                ->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE')
                ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding');
        }
        return  response()->json(
            array(
                "success" => false, "data" => array(), "erros" => array("message" => "invalid user or password")
            ),
            401
        )->header('Content-Type', 'application/json; charset=UTF-8')
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE')
            ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding');
    }
}
