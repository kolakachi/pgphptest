<?php

namespace App\Http\Controllers;


use Exception;
use App\Models\User;
use App\Helpers\StaticVariables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function appendCommentView(){
        $users = User::all();
        $data = [
            'users' => $users
        ];
        return view('comment-form', $data);
    }

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
                "message" => "OK",
                'user' => $user
            ]);


        } catch (Exception $error) {
            return response()->json([
                "message" => "Could not update database: ".  $error->getMessage(),
                "errors" => []
            ], 500);
        }        
    }

    public function index($userId){
        $user = User::where('id', $userId)->first();
        if(!$user){
            abort(404, "User not found");
        }
        $data = [
            'user' => $user
        ];
        return view('user-view', $data);
    }
}
