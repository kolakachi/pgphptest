<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Helpers\StaticVariables;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     *  append comment to the users table
     * 
     *
     * This endpoint uses form data to append to comments.
     * 
     *
     * 
     * @bodyParam id integer required The ID of the user
     * @bodyParam comments string The comments to append
     * @bodyParam password string The static value

     * 
     * @response {
     *  "message": OK,
     * }
     * @response status=422 scenario="Invalid key/value" {
     *  "message": "Invalid key/value",
     *  "errors": {
     *      "id": [
     *          "The selected id is invalid."
     *      ]
     *   },
     * }
     * @response status=401 scenario="Invalid password" {
     *  "message": "Invalid password",
     *  "errors": [],
     * }
     * @response status=%00 scenario="Could not complete request" {
     *  "message": "Could not complete request",
     *  "errors": [],
     * }
    */
    public function update(Request $request){
        try {
            $validator = Validator::make($request->all(), $this->rules());

            if ($validator->fails()) {
                return response()->json([
                    "message" => "Invalid key/value",
                    "errors" => $validator->errors()
                ], 422);
            }

            if($request->password != StaticVariables::STATIC_KEY){
                return response()->json([
                    "message" => "Invalid password",
                    "errors" => []
                ], 401);
            }

            $user = User::where('id', $request->id)->first();
            $user->comments .= "\n".$request->comments;
            $user->save();
            return response()->json([
                "message" => "OK"
            ]);


        } catch (Exception $error) {
            return response()->json([
                "message" => "Could not complete request: ".  $error->getMessage(),
                "errors" => []
            ], 500);
        }        
    }
}
