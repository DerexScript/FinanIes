<?php

namespace App\Http\Controllers;

use App\Models\Release;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ReleaseController extends Controller
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
     *   tags={"Release"},
     *   description="get all release",
     *   summary="get all release",
     *   path="/api/v1/release",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource")
     * )
     */
    public function index()
    {
        return response(
            array("success" => true, "data" => Release::all(), "erros" => array()),
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
     *   tags={"Release"},
     *   path="/api/v1/release",
     *   description="register a new release",
     *   summary="register a new release",
     *   security={{"bearerAuth": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="description",
     *           description="description",
     *           type="string"
     *         ),
     *         @OA\Property(
     *           property="value",
     *           description="value",
     *           type="float"
     *         ),
     *         @OA\Property(
     *           property="date",
     *           description="date",
     *           type="date"
     *         ),
     *         @OA\Property(
     *           property="voucher",
     *           description="The data block for encryption/decryption",
     *           type="string",
     *           format="binary"
     *         ),
     *         @OA\Property(
     *           property="company id",
     *           description="company id",
     *           type="integer"
     *         ),
     *         @OA\Property(
     *           property="category id",
     *           description="category id",
     *           type="integer"
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
            'title' => 'required',
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
        $release = new Release();
        $release->forceFill([
            "name" => $fields["name"],
            "title" => $fields["title"],
        ]);
        if ($release->save()) {
            return response(
                array("success" => true, "data" => array("message" => "release successfully added"), "erros" => array()),
                201
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error when entering release")),
            500
        );
    }

    /**
     * @OA\Post(
     *   tags={"Release"},
     *   path="/api/v1/release/{release}/attach",
     *   description="associate permission to release",
     *   summary="associate permission to release",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="release",
     *       description="release identification",
     *       in="path",
     *       @OA\Schema(type="integer"),
     *   ),
     *  @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="permission_id",
     *           description="permission id",
     *           type="integer",
     *         ),
     *       ),
     *     ),
     *  ),
     * ),
     */
    public function releaseRules(Request $request, $release)
    {
        $rules = [
            'permission_id' => 'required'
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
        $fields = $request->only(['permission_id']);
        $release = Release::find($release);

        if ($release) {
            $tzdate = Carbon::now('Europe/London');
            $release->permissions()->attach($fields['permission_id'], ['created_at' => $tzdate, 'updated_at' => $tzdate]);
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
     * Display the specified resource.
     *
     * @param  \App\Models\Release  $release
     * @return \Illuminate\Http\Response
     */
    public function show(Release $release)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Release  $release
     * @return \Illuminate\Http\Response
     */
    public function edit(Release $release)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Release  $release
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *   tags={"Release"},
     *   path="/api/v1/release/{release}",
     *   description="update a release by id",
     *   summary="update a release by id",
     *   operationId="updateRelease",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="release",
     *       description="release identification",
     *       in="path",
     *       @OA\Schema(type="integer"),
     *   ),
     *  @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="description",
     *           description="description",
     *           type="string"
     *         ),
     *         @OA\Property(
     *           property="value",
     *           description="value",
     *           type="float"
     *         ),
     *         @OA\Property(
     *           property="date",
     *           description="date",
     *           type="date"
     *         ),
     *         @OA\Property(
     *           property="voucher",
     *           description="The data block for encryption/decryption",
     *           type="string",
     *           format="binary"
     *         ),
     *         @OA\Property(
     *           property="company id",
     *           description="company id",
     *           type="integer"
     *         ),
     *         @OA\Property(
     *           property="category id",
     *           description="category id",
     *           type="integer"
     *         ),
     *       ),
     *     ),
     *   ),
     * ),
     */
    public function update(Request $request, $release)
    {
        $rules = [
            'name' => 'required',
            'title' => 'required',
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
        $fields = $request->only(['name', 'title']);
        $release = Release::find($release);
        if ($release && $release->update($fields)) {
            return response(
                array("success" => true, "data" => array("message" => "release successfully updated"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error updating release data")),
            500
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Release  $release
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *   tags={"Release"},
     *   path="/api/v1/release/{release}",
     *   description="delete a release by id",
     *   summary="delete a release by id",
     *   operationId="deleteRelease",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="release",
     *       description="release identification",
     *       in="path",
     *       @OA\Schema(type="integer"),
     *   ),
     * ),
     */
    public function destroy($release)
    {
        $release = Release::find($release);
        if ($release) {
            $release->delete();
            return response(
                array("success" => true, "data" => array("message" => "release successfully deleted"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => true, "data" => array(), "erros" => array("message" => "error when trying to delete the release")),
            404
        );
    }
}
