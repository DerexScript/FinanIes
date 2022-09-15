<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api'); //, ['except' => ['index']]
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *   tags={"Role"},
     *   description="get all roles",
     *   summary="get all roles",
     *   path="/api/v1/role",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource")
     * )
     */
    public function index()
    {
        return response(
            array("success" => true, "data" => Role::all(), "erros" => array()),
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
     *   tags={"Role"},
     *   path="/api/v1/role",
     *   description="register a new role",
     *   summary="register a new role",
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
     *           property="description",
     *           description="description",
     *           type="string"
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
            'description' => 'required'
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
        $fields = $request->only(["name", "description"]);
        $role = new Role();
        $role->forceFill([
            "name" => $fields["name"],
            "description" => $fields["description"]
        ]);
        if ($role->save()) {
            return response(
                array("success" => true, "data" => array("message" => "role successfully added"), "erros" => array()),
                201
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error when entering role")),
            500
        );
    }



    /**
     * @OA\Post(
     *   tags={"Role"},
     *   path="/api/v1/role/{role}/associate",
     *   description="associate role with a permission",
     *   summary="associate role with a permission",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="role",
     *       description="role identification",
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
     *           property="permission_id",
     *           description="permission id",
     *           type="integer"
     *         ),
     *       ),
     *     ),
     *  ),
     * ),
     */
    public function permissionAssociate(Request $request, $role)
    {
        $rules = [
            'permission_id' => 'required|integer'
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
        $role = Role::find($role);
        if ($role) {
            $role->permission()->associate($request['permission_id'])->save();
            return response(
                array("success" => true, "data" => array("message" => "permission successfully associated"), "erros" => array()),
                201
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error associating permission")),
            500
        );
    }


    /**
     * @OA\Post(
     *   tags={"Role"},
     *   path="/api/v1/role/{role}/dissociate",
     *   description="dissociate permission with a role",
     *   summary="dissociate permission with a role",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="role",
     *       description="role identification",
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
     *           property="permission_id",
     *           description="permission id",
     *           type="integer"
     *         ),
     *       ),
     *     ),
     *  ),
     * ),
     */
    public function permissionDisassociate(Request $request, $role)
    {
        $rules = [
            'permission_id' => 'required|integer'
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
        $role = Role::find($role);
        if ($role) {
            $role->permission()->dissociate($request['permission_id'])->save();
            return response(
                array("success" => true, "data" => array("message" => "permission successfully dissociate"), "erros" => array()),
                201
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error dissociate permission")),
            500
        );
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *   tags={"Role"},
     *   path="/api/v1/role/{role}",
     *   description="update a role by id",
     *   summary="update a role by id",
     *   operationId="updateRole",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="role",
     *       description="role identification",
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
     *           property="name",
     *           description="name",
     *           type="string"
     *         ),
     *         @OA\Property(
     *           property="description",
     *           description="description",
     *           type="string"
     *         ),
     *       ),
     *     ),
     *  ),
     * ),
     */
    public function update(Request $request, $role)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required'
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
        $fields = $request->only(["name", "description"]);
        $role = Role::find($role);
        if ($role && $role->update($fields)) {
            return response(
                array("success" => true, "data" => array("message" => "role successfully updated"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error updating role data")),
            500
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *   tags={"Role"},
     *   path="/api/v1/role/{role}",
     *   description="delete a role by id",
     *   summary="delete a role by id",
     *   operationId="deleteRole",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="role",
     *       description="role identification",
     *       in="path",
     *       @OA\Schema(
     *         type="integer"
     *      ),
     *   ),
     * ),
     */
    public function destroy($role)
    {
        $role = Role::find($role);
        if ($role) {
            $role->delete();
            return response(
                array("success" => true, "data" => array("message" => "role successfully deleted"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => true, "data" => array(), "erros" => array("message" => "error when trying to delete the role")),
            404
        );
    }
}
