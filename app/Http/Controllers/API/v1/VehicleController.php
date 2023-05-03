<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VehicleType;

class VehicleController extends Controller
{
            /**
    * @OA\Get(
    *      path="/api/v1/vehicletypes",
    *      summary="Vehicle Type List",
    *      description="This will return vehicle types",
    *      @OA\Response(
    *          response=200,
    *          description="OK",
    *          @OA\JsonContent()
    *       ),
    *      @OA\Response(
    *          response=401,
    *          description="Unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      )
    *     )
    */
    function vehicletypelist()
    {
        $vehicletypes = VehicleType::all();
        return ["vehicletypes"=>$vehicletypes];
    }
}
