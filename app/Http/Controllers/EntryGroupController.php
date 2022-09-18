<?php

namespace App\Http\Controllers;

use App\Models\EntryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class EntryGroupController extends Controller
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
     *   tags={"EntryGroup"},
     *   description="get all entry group",
     *   summary="get all entry group",
     *   path="/api/v1/entry-group",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource")
     * )
     */
    public function index()
    {
        return response(
            array("success" => true, "data" => EntryGroup::all(), "erros" => array()),
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
     *   tags={"EntryGroup"},
     *   path="/api/v1/entry-group",
     *   description="register a new entry group",
     *   summary="register a new entry group",
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
     *        @OA\Property(
     *           property="company_id",
     *           description="company_id",
     *           format="int64",
     *           default=null,
     *           nullable="true",
     *        ),
     *        @OA\Property(
     *           property="entry_id",
     *           description="entry_id",
     *           format="int64",
     *           default=null,
     *           nullable="true",
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
            'status' => 'required'
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
        $fields = $request->only(["name", "description", "status"]);
        $entry = new EntryGroup();
        $entry->forceFill($fields);
        if ($entry->save()) {
            return response(
                array("success" => true, "data" => array("message" => "entry group successfully added"), "erros" => array()),
                201
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error when entering entry group")),
            500
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EntryGroup  $entryGroup
     * @return \Illuminate\Http\Response
     */
    public function show(EntryGroup $entryGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EntryGroup  $entryGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(EntryGroup $entryGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EntryGroup  $entryGroup
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *   tags={"EntryGroup"},
     *   path="/api/v1/entry-group/{entryGroup}",
     *   description="update a entry group by id",
     *   summary="update a entry group by id",
     *   operationId="updateEntryGroup",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="entryGroup",
     *       description="entry group identification",
     *       in="path",
     *       @OA\Schema(type="integer"),
     *   ),
     *  @OA\RequestBody(
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
     *           property="company_id",
     *           description="company_id",
     *           format="int64",
     *           default=null,
     *           nullable="true",
     *        ),
     *        @OA\Property(
     *           property="entry_id",
     *           description="entry_id",
     *           format="int64",
     *           default=null,
     *           nullable="true",
     *        ),
     *       ),
     *     ),
     *   ),
     * ),
     */
    public function update(Request $request, $entryGroup)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'status' => 'required'
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
        $fields = $request->only(['name', 'description', 'status']);
        $entryGroup = EntryGroup::find($entryGroup);
        if ($entryGroup && $entryGroup->update($fields)) {
            return response(
                array("success" => true, "data" => array("message" => "entry group successfully updated"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error updating entry group data")),
            500
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EntryGroup  $entryGroup
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *   tags={"EntryGroup"},
     *   path="/api/v1/entry-group/{entryGroup}}",
     *   description="delete a entry group by id",
     *   summary="delete a entry group by id",
     *   operationId="deleteEntryGroup",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="entryGroup",
     *       description="entry group identification",
     *       in="path",
     *       @OA\Schema(type="integer"),
     *   ),
     * ),
     */
    public function destroy($entryGroup)
    {
        $entryGroup = EntryGroup::find($entryGroup);
        if ($entryGroup) {
            $entryGroup->delete();
            return response(
                array("success" => true, "data" => array("message" => "entry group successfully deleted"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => true, "data" => array(), "erros" => array("message" => "error when trying to delete the entry group")),
            404
        );
    }
}
