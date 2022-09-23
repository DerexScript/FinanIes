<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
     *   description="get all company",
     *   summary="get all company",
     *   path="/api/v1/company",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource")
     * )
     */
    public function index()
    {
        return response(
            array("success" => true, "data" => Company::with('groupEntries')->get(), "erros" => array()),
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
     *   description="register a new company",
     *   summary="register a new company",
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
     *        @OA\Property(
     *           property="user_id",
     *           description="user_id",
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
        $fields = $request->only(["name", "description", "user_id"]);
        $companie = new Company();
        $companie->forceFill($fields);
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
     *   description="update a company by id",
     *   summary="update a company by id",
     *   operationId="updateCompany",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="company",
     *       description="company identification",
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
     *       ),
     *    ),
     *  ),
     * ),
     */
    public function update(Request $request, $company)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
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
        $fields = $request->only(['name', 'description']);
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
     *   description="delete a company by id",
     *   summary="delete a company by id",
     *   operationId="deleteCompany",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="An example resource"),
     *   @OA\Parameter(
     *       required=true,
     *       name="company",
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
