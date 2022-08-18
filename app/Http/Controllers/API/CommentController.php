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
                "message" => "Could not update database: ".  $error->getMessage(),
                "errors" => []
            ], 500);
        }        
    }
}
