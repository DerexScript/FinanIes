<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
