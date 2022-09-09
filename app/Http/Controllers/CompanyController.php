<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
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
     *   tags={"Company"},
     *   path="/api/v1/company",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource")
     * )
     */
    public function index()
    {
        return response(
            array("success" => true, "data" => Company::all(), "erros" => array()),
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
     *   tags={"Company"},
     *   path="/api/v1/company",
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
        $companie = new Company();
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
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *   tags={"Company"},
     *   path="/api/v1/company/{company}",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="company",
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
    public function update(Request $request, $company)
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
        $company = Company::find($company);
        if ($company && $company->update($fields)) {
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
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *   tags={"Company"},
     *   path="/api/v1/company/{company}",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="companie",
     *       description="company identification",
     *       in="path",
     *       @OA\Schema(type="integer"),
     *   ),
     * ),
     */
    public function destroy($company)
    {
        $company = Company::find($company);
        if ($company) {
            $company->delete();
            return response(
                array("success" => true, "data" => array("message" => "company successfully deleted"), "erros" => array()),
                200
            );
        }
        return response(
            array("success" => true, "data" => array(), "erros" => array("message" => "error when trying to delete the company")),
            404
        );
    }
}
