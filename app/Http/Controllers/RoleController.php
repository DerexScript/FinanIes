<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
            array("success" => true, "data" => Role::all(), "erros" => ""),
            200
        );
    }

    /**
     * @OA\Get(
     *   tags={"Role"},
     *   description="get role by id",
     *   summary="get role by id",
     *   path="/api/v1/role/{role}",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource")
     * )
     */
    public function get($role)
    {
        return response(
            array("success" => true, "data" => Role::find($role), "erros" => ""),
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
     *         @OA\Property(
     *           property="role",
     *           description="role",
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
            'description' => 'required',
            'role' => 'required'
        ];
        $messages = [];
        $customAttributes = [];
        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            return response(
                array("success" => false, "message" => "", "data" => array(), "erros" => array("message" => $validator->errors())),
                400
            );
        }
        $fields = $request->only(["name", "description", "role"]);
        $role = new Role();
        $role->forceFill($fields);
        if ($role->save()) {
            return response(
                array("success" => true, "message" => "role successfully added", "data" => $role, "erros" => array()),
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
     *   path="/api/v1/role/{role}/resource/attach",
     *   description="attach role with a resource",
     *   summary="attach role with a resource",
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
     *           property="resource_id",
     *           description="resource id",
     *           type="integer"
     *         ),
     *       ),
     *     ),
     *  ),
     * ),
     */
    public function resourceAttach(Request $request, $role)
    {
        $rules = [
            'resource_id' => 'required|integer'
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
        $resource = Resource::find($request['resource_id']);
        if ($role && $resource) {
            $tzdate = Carbon::now('Europe/London');
            $role->resources()->attach($request['resource_id'], ['created_at' => $tzdate, 'updated_at' => $tzdate]);
            return response(
                array("success" => true, "data" => array("message" => "resource successfully attach"), "erros" => array()),
                201
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error attach resource")),
            500
        );
    }


    /**
     * @OA\Post(
     *   tags={"Role"},
     *   path="/api/v1/role/{role}/resource/detach",
     *   description="detach role with a resource",
     *   summary="detach role with a resource",
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
     *           property="resource_id",
     *           description="resource id",
     *           type="integer"
     *         ),
     *       ),
     *     ),
     *  ),
     * ),
     */
    public function resourceDetach(Request $request, $role)
    {
        $rules = [
            'resource_id' => 'required|integer'
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
            $role->resources()->detach($request['resource_id']);
            return response(
                array("success" => true, "data" => array("message" => "resource successfully detach"), "erros" => array()),
                201
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error detach resource")),
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
     *         @OA\Property(
     *           property="role",
     *           description="role",
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
            'description' => 'required',
            'role' => 'required',
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
        $fields = $request->only(["name", "description", "role"]);
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
