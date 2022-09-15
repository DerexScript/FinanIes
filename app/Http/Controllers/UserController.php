<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *   tags={"User"},
     *   description="get all users",
     *   summary="get all users",
     *   path="/api/v1/user",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource")
     * )
     */
    public function index()
    {
        return response(
            array("success" => true, "data" => User::all(), "erros" => array()),
            200
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *   tags={"User"},
     *   path="/api/v1/user",
     *   description="register a new user",
     *   summary="register a new user",
     *   security={{"bearerAuth": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="name",
     *           description="name",
     *           type="string"
     *         ),
     *         @OA\Property(
     *           property="surname",
     *           description="surname",
     *           type="string"
     *         ),
     *         @OA\Property(
     *           property="email",
     *           description="email",
     *           type="string"
     *         ),
     *         @OA\Property(
     *           property="username",
     *           description="username",
     *           type="string"
     *         ),
     *         @OA\Property(
     *           property="password",
     *           description="password",
     *           type="string"
     *         ),
     *         @OA\Property(
     *           property="is_admin",
     *           description="is_admin",
     *           type="boolean"
     *         ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(response="200", description="An example resource")
     * )
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'is_admin' => 'required',
        ];
        $messages = [];
        $customAttributes = [];
        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            return response(
                array("success" => false, "data" => array(), "erros" => $validator->errors()),
                400
            );
        }
        $fields = $request->only(["name", "surname", "email", "username", "email_verified_at", "password", "is_admin"]);
        $user = new User();
        $user->forceFill([
            "name" => $fields["name"],
            "surname" => $fields["surname"],
            "email" => $fields["email"],
            "username" => $fields["username"],
            "password" => Hash::make($fields["password"]),
            "is_admin" => $fields["is_admin"]
        ])->setRememberToken(Str::random(60));

        if ($user->save()) {
            return response(
                array("success" => true, "data" => array("message" => "user successfully added"), "erros" => array()),
                201
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error when entering user")),
            500
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }



    /**
     * @OA\Post(
     *   tags={"User"},
     *   path="/api/v1/user/{user}/associated",
     *   description="associated user with a role",
     *   summary="associated user with a role",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="user",
     *       description="user identification",
     *       in="path",
     *       @OA\Schema(
     *         type="integer"
     *      ),
     *   ),
     *  @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="role_id",
     *           description="role id",
     *           type="integer"
     *         ),
     *       ),
     *     ),
     *  ),
     * ),
     */
    public function roleAssociate(Request $request, $user)
    {
        $rules = [
            'role_id' => 'required|integer'
        ];
        $messages = [];
        $customAttributes = [];
        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            return response(
                array("success" => false, "data" => array(), "erros" => $validator->errors()),
                400
            );
        }
        $user = User::find($user);
        if ($user) {
            $user->role()->associate($request['role_id'])->save();
            return response(
                array("success" => true, "data" => array("message" => "role successfully associated"), "erros" => array()),
                201
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error associating user")),
            500
        );
    }


    /**
     * @OA\Post(
     *   tags={"User"},
     *   path="/api/v1/user/{user}/dissociate",
     *   description="dissociate user with a role",
     *   summary="dissociate user with a role",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="user",
     *       description="user identification",
     *       in="path",
     *       @OA\Schema(
     *         type="integer"
     *      ),
     *   ),
     *  @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="role_id",
     *           description="role id",
     *           type="integer"
     *         ),
     *       ),
     *     ),
     *  ),
     * ),
     */
    public function roleDisassociate(Request $request, $user)
    {
        $rules = [
            'role_id' => 'required|integer'
        ];
        $messages = [];
        $customAttributes = [];
        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            return response(
                array("success" => false, "data" => array(), "erros" => $validator->errors()),
                400
            );
        }
        $user = User::find($user);
        if ($user) {
            $user->role()->dissociate($request['role_id'])->save();
            return response(
                array("success" => true, "data" => array("message" => "role successfully dissociate"), "erros" => array()),
                201
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error dissociate user")),
            500
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *   tags={"User"},
     *   path="/api/v1/user/{user}",
     *   description="update a user by id",
     *   summary="update a user by id",
     *   operationId="updateUser",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="user",
     *       description="user identification",
     *       in="path",
     *       @OA\Schema(
     *         type="integer"
     *      ),
     *  ),
     *  @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="name",
     *           description="name",
     *           type="string"
     *         ),
     *         @OA\Property(
     *           property="surname",
     *           description="surname",
     *           type="string"
     *         ),
     *         @OA\Property(
     *           property="email",
     *           description="email",
     *           type="string"
     *         ),
     *         @OA\Property(
     *           property="username",
     *           description="username",
     *           type="string"
     *         ),
     *         @OA\Property(
     *           property="password",
     *           description="password",
     *           type="string"
     *         ),
     *         @OA\Property(
     *           property="is_admin",
     *           description="is_admin",
     *           type="boolean"
     *         ),
     *       ),
     *     ),
     *  ),
     * ),
     */
    public function update(Request $request, $user)
    {
        $rules = [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'is_admin' => 'required',
        ];
        $messages = [];
        $customAttributes = [];
        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            return response(
                array("success" => false, "data" => array(), "erros" => $validator->errors()),
                400
            );
        }
        $fields = $request->only(["name", "surname", "email", "username", "password", "is_admin"]);
        $user = User::find($user);
        if ($user && $user->update($fields)) {
            return response(
                array("success" => true, "data" => array("message" => "user successfully updated"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error updating user data")),
            500
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *   tags={"User"},
     *   path="/api/v1/user/{user}",
     *   description="delete a user by id",
     *   summary="delete a user by id",
     *   operationId="deleteUser",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="user",
     *       description="user identification",
     *       in="path",
     *       @OA\Schema(
     *         type="integer"
     *      ),
     *   ),
     * ),
     */
    public function destroy($user)
    {
        $user = User::find($user);
        if ($user) {
            $user->delete();
            return response(
                array("success" => true, "data" => array("message" => "user successfully deleted"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => true, "data" => array(), "erros" => array("message" => "error when trying to delete the user")),
            404
        );
    }
}
