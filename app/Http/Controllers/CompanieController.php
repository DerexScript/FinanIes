<?php

namespace App\Http\Controllers;

use App\Models\Companie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanieController extends Controller
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
     *   tags={"Companie"},
     *   path="/api/v1/companie",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource")
     * )
     */
    public function index()
    {
        return Companie::all();
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
     *   tags={"Companie"},
     *   path="/api/v1/companie",
     *   security={{"bearerAuth": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="name",
     *           description="companie name",
     *           type="string",
     *           default="conpanie one",
     *         ),
     *         @OA\Property(
     *           property="title",
     *           description="title companie",
     *           type="string",
     *           default="title companie",
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
            'title' => 'required'
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
        $companie = new Companie();
        $companie->forceFill([
            "name" => $fields["name"],
            "title" => $fields["title"],
        ]);
        if ($companie->save()) {
            return response(
                array("success" => true, "data" => array("message" => "company successfully added"), "erros" => array()),
                201
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error when entering company")),
            500
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Companie  $companie
     * @return \Illuminate\Http\Response
     */
    public function show(Companie $companie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Companie  $companie
     * @return \Illuminate\Http\Response
     */
    public function edit(Companie $companie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Companie  $companie
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *   tags={"Companie"},
     *   path="/api/v1/companie",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="companie",
     *       description="company identification",
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
     *           description="companie name",
     *           type="string",
     *           default="conpanie one",
     *         ),
     *         @OA\Property(
     *           property="title",
     *           description="title companie",
     *           type="string",
     *           default="title companie",
     *         ),
     *       ),
     *     ),
     *  ),
     * ),
     */
    public function update(Request $request, Companie $companie)
    {
        $rules = [
            'name' => 'required',
            'title' => 'required'
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
        if ($companie->update($fields)) {
            return response(
                array("success" => true, "data" => array("message" => "company successfully updated"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error updating company data")),
            500
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Companie  $companie
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *   tags={"Companie"},
     *   path="/api/v1/companie",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="companie",
     *       description="company identification",
     *       in="query",
     *       @OA\Schema(type="integer"),
     *   ),
     * ),
     */
    public function destroy(Companie $companie)
    {
        if ($companie->delete()) {
            return response(
                array("success" => true, "data" => array("message" => "company successfully deleted"), "erros" => array()),
                200
            );
        }
    }
}
