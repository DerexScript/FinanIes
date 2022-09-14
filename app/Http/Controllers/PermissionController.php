<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
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
     *   tags={"Permission"},
     *   description="get all permissions",
     *   summary="get all permissions",
     *   path="/api/v1/permission",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource")
     * )
     */
    public function index()
    {
        return response(
            array("success" => true, "data" => Permission::all(), "erros" => array()),
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
     *   tags={"Permission"},
     *   path="/api/v1/permission",
     *   description="register a new permission",
     *   summary="register a new permission",
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
     *           property="view",
     *           description="view",
     *           type="boolean"
     *         ),
     *         @OA\Property(
     *           property="edit",
     *           description="edit",
     *           type="boolean"
     *         ),
     *         @OA\Property(
     *           property="delete",
     *           description="delete",
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
            'description' => 'required',
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
        $fields = $request->only(["name", "title"]);
        $permission = new Permission();
        $permission->forceFill([
            "name" => $fields["name"],
            "description" => $fields["title"],
            "view" => $fields["view"],
            "edit" => $fields["edit"],
            "delete" => $fields["delete"],
        ]);
        if ($permission->save()) {
            return response(
                array("success" => true, "data" => array("message" => "permission successfully added"), "erros" => array()),
                201
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error when entering permission")),
            500
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *   tags={"Permission"},
     *   path="/api/v1/permission/{permission}",
     *   description="update a permission by id",
     *   summary="update a permission by id",
     *   operationId="updatePermission",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="permission",
     *       description="permission identification",
     *       in="path",
     *       @OA\Schema(type="integer"),
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
     *           property="view",
     *           description="view",
     *           type="boolean"
     *         ),
     *         @OA\Property(
     *           property="edit",
     *           description="edit",
     *           type="boolean"
     *         ),
     *         @OA\Property(
     *           property="delete",
     *           description="delete",
     *           type="boolean"
     *         ),
     *       ),
     *     ),
     *  ),
     * ),
     */
    public function update(Request $request, $permission)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
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
        $fields = $request->only(['name', 'description', 'view', 'edit', 'delete']);
        $permission = Permission::find($permission);
        if ($permission && $permission->update($fields)) {
            return response(
                array("success" => true, "data" => array("message" => "permission successfully updated"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error updating permission data")),
            500
        );
    }



    /**
     * @OA\Post(
     *   tags={"Permission"},
     *   path="/api/v1/permission/{permission}/attach",
     *   description="associate permission to category",
     *   summary="associate permission to category",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="permission",
     *       description="permission identification",
     *       in="path",
     *       @OA\Schema(type="integer"),
     *   ),
     *  @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="category_id",
     *           description="category id",
     *           type="integer",
     *         ),
     *       ),
     *     ),
     *  ),
     * ),
     */
    public function categoryRules(Request $request, $permission)
    {
        $rules = [
            'category_id' => 'required'
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
        $fields = $request->only(['category_id']);
        $permission = Permission::find($permission);

        if ($permission) {
            $tzdate = Carbon::now('Europe/London');
            $permission->permissions()->attach($fields['permission_id'], ['created_at' => $tzdate, 'updated_at' => $tzdate]);
            return response(
                array("success" => true, "data" => array('message' => "successful association"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error when associating")),
            500
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *   tags={"Permission"},
     *   path="/api/v1/permission/{permission}",
     *   description="delete a permission by id",
     *   summary="delete a permission by id",
     *   operationId="deletePermission",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="permission",
     *       description="permission identification",
     *       in="path",
     *       @OA\Schema(type="integer"),
     *   ),
     * ),
     */
    public function destroy($permission)
    {
        $permission = Permission::find($permission);
        if ($permission) {
            $permission->delete();
            return response(
                array("success" => true, "data" => array("message" => "permission successfully deleted"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => true, "data" => array(), "erros" => array("message" => "error when trying to delete the permission")),
            404
        );
    }
}
