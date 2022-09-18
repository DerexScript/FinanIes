<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class EntryController extends Controller
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
     *   tags={"Entry"},
     *   description="get all entry",
     *   summary="get all entry",
     *   path="/api/v1/entry",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource")
     * )
     */
    public function index()
    {
        return response(
            array("success" => true, "data" => Entry::all(), "erros" => array()),
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
     *   tags={"Entry"},
     *   path="/api/v1/entry",
     *   description="register a new entry",
     *   summary="register a new entry",
     *   security={{"bearerAuth": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         required={"description", "value", "date", "status"},
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
     *           property="category_id",
     *           description="category_id",
     *           format="int64",
     *           default=null,
     *           nullable="true",
     *        ),
     *       ),
     *     ),
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         required={"voucher"},
     *         @OA\Property(
     *           description="file image to upload",
     *           property="voucher",
     *           type="string",
     *           format="binary",
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
            'description' => 'required',
            'value' => 'required',
            'date' => 'required',
            'voucher' => 'required',
            'status' => 'required|boolean',
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
        $fields = $request->only(["description", "value", "date", "voucher", "status", "company_id", "category_id"]);
        $entry = new Entry();
        $entry->forceFill($fields);
        if ($entry->save()) {
            return response(
                array("success" => true, "data" => array("message" => "entry successfully added"), "erros" => array()),
                201
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error when entering entry")),
            500
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *   tags={"Entry"},
     *   path="/api/v1/entry/{entry}",
     *   description="update a entry by id",
     *   summary="update a entry by id",
     *   operationId="updateEntry",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="entry",
     *       description="entry identification",
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
     *           property="status",
     *           description="status",
     *           type="boolean",
     *         ),
     *       ),
     *     ),
     *   ),
     * ),
     */
    public function update(Request $request, $entry)
    {
        $rules = [
            'description' => 'required',
            'value' => 'required',
            'date' => 'required',
            'voucher' => 'required',
            'status' => 'required|boolean',
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
        $fields = $request->only(['description', 'value', 'date', 'voucher', 'status']);
        $entry = Entry::find($entry);
        if ($entry && $entry->update($fields)) {
            return response(
                array("success" => true, "data" => array("message" => "entry successfully updated"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error updating entry data")),
            500
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *   tags={"Entry"},
     *   path="/api/v1/entry/{entry}",
     *   description="delete a entry by id",
     *   summary="delete a entry by id",
     *   operationId="deleteEntry",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="entry",
     *       description="entry identification",
     *       in="path",
     *       @OA\Schema(type="integer"),
     *   ),
     * ),
     */
    public function destroy($entry)
    {
        $entry = Entry::find($entry);
        if ($entry) {
            $entry->delete();
            return response(
                array("success" => true, "data" => array("message" => "entry successfully deleted"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => true, "data" => array(), "erros" => array("message" => "error when trying to delete the entry")),
            404
        );
    }
}
