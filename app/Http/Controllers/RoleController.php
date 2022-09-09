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
     *   security={{"bearerAuth": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="name",
     *           description="role name",
     *           type="string",
     *           default="role-one",
     *         ),
     *         @OA\Property(
     *           property="view",
     *           description="view role",
     *           type="boolean",
     *           default="true",
     *         ),
     *         @OA\Property(
     *           property="edit",
     *           description="edit role",
     *           type="boolean",
     *           default="true",
     *         ),
     *         @OA\Property(
     *           property="delete",
     *           description="delete role",
     *           type="boolean",
     *           default="true",
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
            'view' => 'required',
            'edit' => 'required',
            'delete' => 'required',
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
        $fields = $request->only(["name", "view", "edit", "delete"]);
        $role = new Role();
        $role->forceFill([
            "name" => $fields["name"],
            "view" => $fields["view"],
            "edit" => $fields["edit"],
            "delete" => $fields["delete"],
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
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="companie",
     *       description="role identification",
     *       in="query",
     *       @OA\Schema(type="integer"),
     *   ),
     *  @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="name",
     *           description="role name",
     *           type="string",
     *           default="role-one",
     *         ),
     *         @OA\Property(
     *           property="view",
     *           description="permission to see",
     *           type="boolean",
     *           default="true",
     *         ),
     *         @OA\Property(
     *           property="edit",
     *           description="permission to edit",
     *           type="boolean",
     *           default="true",
     *         ),
     *         @OA\Property(
     *           property="delete",
     *           description="permission to delete",
     *           type="boolean",
     *           default="true",
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
            'view' => 'required|boolean',
            'edit' => 'required|boolean',
            'delete' => 'required|boolean',
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
        $fields = $request->only(["name", "view", "edit", "delete"]);
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
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="role",
     *       description="role identification",
     *       in="path",
     *       @OA\Schema(type="integer"),
     *   ),
     * ),
     */
    public function destroy($role)
    {
        $role = Role::find($role);
        if ($role) {
            $role->delete();
            return response(
                array("success" => true, "data" => array("message" => "function successfully deleted"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => true, "data" => array(), "erros" => array("message" => "error when trying to delete the function")),
            404
        );
    }
}
