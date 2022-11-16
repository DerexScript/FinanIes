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
        $release = Release::all()->toArray();
        $release = array_map(function ($release) {
            $appURL = env('APP_URL', true);
            $release['voucher'] = $appURL . $release['voucher'];
            return $release;
        }, $release);
        return response(
            array("success" => true, "data" => $release, "erros" => array()),
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
     * @OA\Get(
     *   tags={"Release"},
     *   description="get release by id",
     *   summary="get release by id",
     *   path="/api/v1/release/{Release}",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(response="200", description="Success"),
     *    @OA\Parameter(
     *       required=true,
     *       name="release",
     *       description="release identification",
     *       in="path",
     *       @OA\Schema(type="integer"),
     *   ),
     * )
     */
    public function get($release)
    {
        $release = Release::find($release);
        if ($release) {
            $appURL = env('APP_URL', true);
            $release->voucher = $appURL . $release->voucher;
            return response(
                array("success" => true, "message" => "release found", "data" => $release, "erros" => ""),
                200
            );
        }
        return response(
            array("success" => false, "message" => "release not found", "data" => array(), "erros" => array("message" => "release not found")),
            404
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     *   @OA\Post(
     *       tags={"Release"},
     *       path="/api/v1/release",
     *       description="register a new release",
     *       summary="register a new release",
     *       security={{"bearerAuth": {}}},
     *       @OA\RequestBody(
     *           required=true,
     *           @OA\MediaType(
     *               mediaType="multipart/form-data",
     *               @OA\Schema(
     *                   required={"description", "value", "status", "voucher", "category_id", "release_group_id"},
     *                   @OA\Property(
     *                       property="release_group_id",
     *                       description="input group id",
     *                       format="int64",
     *                   ),
     *                   @OA\Property(
     *                       property="description",
     *                       description="description",
     *                       type="string"
     *                   ),
     *                   @OA\Property(
     *                       property="value",
     *                       description="value",
     *                       type="float"
     *                   ),
     *                   @OA\Property(
     *                       property="voucher",
     *                       description="image proof",
     *                       type="string",
     *                       format="binary"
     *                   ),
     *                   @OA\Property(
     *                       property="type",
     *                       description="defines whether the posting is outgoing or incoming",
     *                       type="boolean",
     *                   ),
     *                   @OA\Property(
     *                       property="insert_date",
     *                       description="insert date of release",
     *                       type="datetime",
     *                   ),
     *                   @OA\Property(
     *                       property="category_id",
     *                       description="category_id",
     *                       format="int64",
     *                   ),
     *               ),
     *           ),
     *       ),
     *       @OA\Response(response="201", description="success")
     *   )
     */
    public function store(Request $request)
    {
        $rules = [
            'description' => 'required',
            'category_id' => 'required',
            'value' => 'required',
            'type' => 'required',
            'insert_date' => 'required',
            'release_group_id' => 'required',
            'voucher' => 'mimes:jpg,jpeg,bmp,png,webp|max:2048|required'
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
        // $tzdate = Carbon::now('Europe/London');
        $fileName = $request->file('voucher')->getClientOriginalName();
        $format =  substr($fileName, (strripos($fileName, ".") + 1), (strlen($fileName) - 1));
        $pathName = $request->file('voucher')->getPathname();
        $fileContent = file_get_contents($pathName);
        $FilheHash = sha1($fileContent);
        $upload = move_uploaded_file($pathName, base_path() . '/public/uploads/' . $FilheHash . '.' . $format);
        if ($upload) {
            $fields = $request->only(["description", "value", "voucher", "insert_date", "type", "category_id", "release_group_id"]);
            // $fields['insert_date'] = $tzdate;
            $fields['type'] = filter_var($fields['type'], FILTER_VALIDATE_BOOLEAN);
            $fields['voucher'] = '/uploads/' . $FilheHash . '.' . $format;
            $release = new Release();
            $release->forceFill($fields);
            $save = $release->save();
            if ($save) {
                return response(
                    array("success" => true, "message" => "release successfully added", "data" => $release, "erros" => array()),
                    201
                );
            }
        }
        return response(
            array("success" => false, "data" => array(), "erros" => array("message" => "error when entering release")),
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
     * @OA\Post(
     *   tags={"Release"},
     *   path="/api/v1/release/{release}",
     *   description="update a release by id",
     *   summary="update a release by id",
     *   operationId="updateRelease",
     *   security={{"bearerAuth": {}}},
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
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *         required={"description", "value", "status", "category_id", "release_group_id", "_method"},
     *         @OA\Property(
     *           property="release_group_id",
     *           description="input group id",
     *           type="int64"
     *         ),
     *         @OA\Property(
     *           property="description",
     *           description="launch description",
     *           type="float"
     *         ),
     *         @OA\Property(
     *           property="value",
     *           description="value",
     *           type="float"
     *         ),
     *         @OA\Property(
     *           property="voucher",
     *           description="image proof",
     *           type="string",
     *           format="binary"
     *         ),
     *         @OA\Property(
     *           property="type",
     *           description="defines whether the posting is outgoing or incoming",
     *           type="boolean",
     *         ),
     *         @OA\Property(
     *            property="insert_date",
     *            description="insert date of release",
     *            type="datetime",
     *         ),
     *         @OA\Property(
     *           property="category_id",
     *           description="category_id",
     *           format="int64",
     *         ),
     *         @OA\Property(
     *           property="_method",
     *           description="metodo",
     *           type="string",
     *           default="PUT",
     *         ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(response="200", description="An example resource")
     * )
     */
    public function update(Request $request, $release)
    {
        $rules = [
            'description' => 'required',
            'value' => 'required',
            'voucher' => 'mimes:jpg,jpeg,bmp,png,webp|max:2048',
            'insert_date' => 'required',
            'type' => 'required',
            'category_id' => 'required',
            'release_group_id' => 'required'
        ];
        $messages = [];
        $customAttributes = [];
        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            return response(
                array("success" => false, "message" => "failed validation", "data" => array(), "erros" => $validator->errors()),
                400
            );
        }
        $fields = $request->only(["description", "value", "voucher", "type", "category_id", "release_group_id"]);
        $fields['type'] = filter_var($fields['type'], FILTER_VALIDATE_BOOLEAN);
        if ($request->hasFile("voucher") && $request->file("voucher")->isValid()) {
            $fileName = $request->file('voucher')->getClientOriginalName();
            $format =  substr($fileName, (strripos($fileName, ".") + 1), (strlen($fileName) - 1));
            $pathName = $request->file('voucher')->getPathname();
            $fileContent = file_get_contents($pathName);
            $filheHash = sha1($fileContent);
            $upload = move_uploaded_file($pathName, base_path() . '/public/uploads/' . $filheHash . '.' . $format);
            if (!$upload) {
                return response(
                    array("success" => false, "message" => "error editing information of a release", "data" => array(), "erros" => array("message" => "error editing image of a release")),
                    500
                );
            }
            $fields['voucher'] = '/uploads/' . $filheHash . '.' . $format;
        }
        $release = Release::find($release);
        if ($release && $release->update($fields)) {
            return response(
                array("success" => true, "message" => "release successfully updated", "data" => $release, "erros" => array()),
                200
            );
        }
        return response(
            array("success" => false, "message" => "error editing information of a release", "data" => array(), "erros" => array("message" => "error updating release data")),
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
