<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ResourceController extends Controller
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
     *   tags={"Resource"},
     *   description="get all resource",
     *   summary="get all resource",
     *   path="/api/v1/resource",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource")
     * )
     */
    public function index()
    {
        return response(
            array("success" => true, "data" => Resource::all(), "erros" => array()),
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
     *   tags={"Resource"},
     *   path="/api/v1/resource",
     *   description="register a new resource",
     *   summary="register a new resource",
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
     *           property="resource",
     *           description="resource",
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
            'resource' => 'required'
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
        $fields = $request->only(["name", "resource"]);
        $resource = new Resource();
        $resource->forceFill([
            "name" => $fields["name"],
            "resource" => $fields["resource"]
        ]);
        if ($resource->save()) {
            return response(
                array("success" => true, "data" => array("message" => "resource successfully added"), "erros" => array()),
                201
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error when entering resource")),
            500
        );
    }


    /**
     * @OA\Post(
     *   tags={"Resource"},
     *   path="/api/v1/resource/{resource}/role/attach",
     *   description="attach resource with a role",
     *   summary="attach resource with a role",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="resource",
     *       description="resource identification",
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
    public function roleAttach(Request $request, $resource)
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
        $resource = Resource::find($resource);
        $role = Role::find($request['role_id']);
        if ($resource && $role && !$resource->roles->contains($request['role_id'])) {
            $tzdate = Carbon::now('Europe/London');
            $resource->roles()->attach($request['role_id'], ['created_at' => $tzdate, 'updated_at' => $tzdate]);
            return response(
                array("success" => true, "data" => array("message" => "role successfully attach"), "erros" => array()),
                201
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error attach role")),
            500
        );
    }


    /**
     * @OA\Post(
     *   tags={"Resource"},
     *   path="/api/v1/resource/{resource}/role/detach",
     *   description="detach resource with a role",
     *   summary="detach resource with a role",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="resource",
     *       description="resource identification",
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
    public function roleDetach(Request $request, $resource)
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
        $resource = Resource::find($resource);
        if ($resource) {
            $resource->roles()->detach($request['role_id']);
            return response(
                array("success" => true, "data" => array("message" => "role successfully detach"), "erros" => array()),
                201
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error detach role")),
            500
        );
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *   tags={"Resource"},
     *   path="/api/v1/resource/{resource}",
     *   description="update a resource by id",
     *   summary="update a resource by id",
     *   operationId="updateResource",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="resource",
     *       description="resource identification",
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
     *           property="resource",
     *           description="resource",
     *           type="string"
     *         ),
     *       ),
     *     ),
     *  ),
     * ),
     */
    public function update(Request $request, $resource)
    {
        $rules = [
            'name' => 'required',
            'resource' => 'required'
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
        $fields = $request->only(["name", "resource"]);
        $resource = Resource::find($resource);
        if ($resource && $resource->update($fields)) {
            return response(
                array("success" => true, "data" => array("message" => "resource successfully updated"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error updating resource data")),
            500
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *   tags={"Resource"},
     *   path="/api/v1/resource/{resource}",
     *   description="delete a resource by id",
     *   summary="delete a resource by id",
     *   operationId="deleteResource",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="resource",
     *       description="resource identification",
     *       in="path",
     *       @OA\Schema(
     *         type="integer"
     *      ),
     *   ),
     * ),
     */
    public function destroy($resource)
    {
        $resource = Resource::find($resource);
        if ($resource) {
            $resource->delete();
            return response(
                array("success" => true, "data" => array("message" => "resource successfully deleted"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => true, "data" => array(), "erros" => array("message" => "error when trying to delete the resource")),
            404
        );
    }
}
