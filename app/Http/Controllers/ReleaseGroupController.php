<?php

namespace App\Http\Controllers;

use App\Models\ReleaseGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ReleaseGroupController extends Controller
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
     *   tags={"ReleaseGroup"},
     *   description="get all release group",
     *   summary="get all release group",
     *   path="/api/v1/release-group",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource")
     * )
     */
    public function index()
    {
        return response(
            array("success" => true, "data" => ReleaseGroup::all(), "erros" => array()),
            200
        );
    }

    /**
     * @OA\Get(
     *   tags={"ReleaseGroup"},
     *   description="get release group by id",
     *   summary="get release group by id",
     *   path="/api/v1/release-group/{releaseGroup}",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="Success"),
     *    @OA\Parameter(
     *       required=true,
     *       name="releaseGroup",
     *       description="release group identification",
     *       in="path",
     *       @OA\Schema(type="integer"),
     *   ),
     * )
     */
    public function get($releaseGroup)
    {
        $releaseGroup = ReleaseGroup::find($releaseGroup);
        if ($releaseGroup) {
            // $appURL = env('APP_URL', true);
            // $releaseGroup->company->image_name = $appURL . $releaseGroup->company->image_name;
            return response(
                array("success" => true, "message" => "release group found", "data" => $releaseGroup, "erros" => array()),
                200
            );
        }
        return response(
            array("success" => false, "message" => "release group not found", "data" => array(), "erros" => array("message" => "release group not found")),
            404
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
     *   tags={"ReleaseGroup"},
     *   path="/api/v1/release-group",
     *   description="register a new release group",
     *   summary="register a new release group",
     *   security={{"bearerAuth": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         required={"name", "description", "status"},
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
     *           property="status",
     *           description="status",
     *           type="boolean"
     *         ),
     *         @OA\Property(
     *           property="expiration",
     *           description="expiration time of this release group",
     *           format="int64",
     *           default=null,
     *           nullable="true",
     *        ),
     *        @OA\Property(
     *           property="company_id",
     *           description="company_id",
     *           format="int64",
     *           default=null,
     *           nullable="true",
     *        ),
     *        @OA\Property(
     *           property="_method",
     *           description="metodo",
     *           type="string",
     *           default="PUT",
     *        ),
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
            'status' => 'required',
            'expiration' => 'required',
            'company_id' => 'required'
        ];
        $messages = [];
        $customAttributes = [];
        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            return response(
                array("success" => false, "message" => "faill", "data" => array(), "erros" => $validator->errors()),
                400
            );
        }
        $fields = $request->only(["name", "description", "status", 'expiration', 'company_id']);
        $fields['status'] = filter_var($fields['status'], FILTER_VALIDATE_BOOLEAN);
        $releaseGroup = new ReleaseGroup();
        $releaseGroup->forceFill($fields);
        if ($releaseGroup->save()) {
            return response(
                array("success" => true, "message" => "releaseGroup group successfully added", "data" => $releaseGroup, "erros" => array()),
                201
            );
        }
        return response(
            array("success" => false, "message" => "faill", "data" => array(), "erros" => array("message" => "error when entering releaseGroup group")),
            500
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReleaseGroup  $releaseGroup
     * @return \Illuminate\Http\Response
     */
    public function show(ReleaseGroup $releaseGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReleaseGroup  $releaseGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(ReleaseGroup $releaseGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReleaseGroup  $releaseGroup
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *   tags={"ReleaseGroup"},
     *   path="/api/v1/release-group/{releaseGroup}",
     *   description="update a release group by id",
     *   summary="update a release group by id",
     *   operationId="updateReleaseGroup",
     *   security={{"bearerAuth": {}}},
     *   @OA\Parameter(
     *       required=true,
     *       name="releaseGroup",
     *       description="release group identification",
     *       in="path",
     *       @OA\Schema(type="integer"),
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         required={"name", "description", "status"},
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
     *           property="status",
     *           description="status",
     *           type="boolean",
     *         ),
     *        @OA\Property(
     *           property="expiration",
     *           description="expiration time of this release group",
     *           format="int64",
     *           default=null,
     *           nullable="true",
     *        ),
     *        @OA\Property(
     *           property="company_id",
     *           description="company_id",
     *           format="int64",
     *           default=null,
     *           nullable="true",
     *        ),
     *        @OA\Property(
     *           property="_method",
     *           description="metodo",
     *           type="string",
     *           default="PUT",
     *        ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(response="200", description="Success")
     * )
     */
    public function update(Request $request, $releaseGroup)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'expiration' => 'required',
            'company_id' => 'required'
        ];
        $messages = [];
        $customAttributes = [];
        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            return response(
                array("success" => false, "message" => "data validation error", "data" => array(), "erros" => $validator->errors()),
                400
            );
        }
        $fields = $request->only(['name', 'description', 'status', 'expiration', 'company_id']);
        $fields['status'] = filter_var($fields['status'], FILTER_VALIDATE_BOOLEAN);
        $releaseGroup = ReleaseGroup::find($releaseGroup);
        if ($releaseGroup && $releaseGroup->update($fields)) {
            return response(
                array("success" => true, "message" => "success", "data" => array("message" => "releaseGroup group successfully updated"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => false, "message" => "fail", "data" => array(), "erros" => array("message" => "error updating releaseGroup group data")),
            500
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReleaseGroup  $releaseGroup
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *   tags={"ReleaseGroup"},
     *   path="/api/v1/release-group/{releaseGroup}}",
     *   description="delete a release group by id",
     *   summary="delete a release group by id",
     *   operationId="deleteReleaseGroup",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="releaseGroup",
     *       description="releaseGroup group identification",
     *       in="path",
     *       @OA\Schema(type="integer"),
     *   ),
     * ),
     */
    public function destroy($releaseGroup)
    {
        $releaseGroup = ReleaseGroup::find($releaseGroup);
        if ($releaseGroup) {
            $releaseGroup->delete();
            return response(
                array("success" => true, "data" => array("message" => "release group successfully deleted"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => true, "data" => array(), "erros" => array("message" => "error when trying to delete the release group")),
            404
        );
    }
}
